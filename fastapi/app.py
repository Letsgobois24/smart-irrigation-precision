from fastapi import FastAPI, HTTPException, Path
from fastapi.responses import JSONResponse

from schema.node_tree import NodeTree
from schema.environment import Environment

from contextlib import asynccontextmanager
from services.mqtt.mqtt_app import startup_event
from services.mqtt.mqtt_client import client
from services.mqtt.mqtt_services import send_request, wait_to_response
from database.influxdb.influxdb_services import handle_create_node, handle_create_env
import json

@asynccontextmanager
async def lifespan(app: FastAPI):
    startup_event()
    yield

app = FastAPI(lifespan=lifespan)

# Main control
@app.post('/device/main/control')
def control_main(data: dict):
    try:
        client.publish('device/main/control', payload=json.dumps(data))
        return {
            'type': 'success',
            'message' : 'Success to deactivate main valve'
        }
    except Exception as e:
        raise HTTPException(status_code=500, detail=f"Failed to publish: {e}")

# Request data from IoT
@app.get('/device/{node_id}/request_data')
def request_data(node_id: str = Path(examples=['main', 'node_1', 'node_2'], description='Unique node identifier')):
    try:
        # Publish to IoT
        request_id, error = send_request(node_id, client)
        if(error):
            raise HTTPException(status_code=500, detail=f"Failed publish to MQTT broker: {error}")

        # Wait response from IoT
        data = wait_to_response(request_id, 5)
        if (data is None):
            raise HTTPException(status_code=500, detail=f"Failed to sent from publisher")

        # Save to database
        data.pop('request_id')
        if(data['node_id'] == 'main'):
            data.pop('node_id')
            handle_create_env(Environment(**data))
        else:
            handle_create_node(NodeTree(**data))

        return JSONResponse(status_code=200, content={
            'message' : 'Success to request data',
            'data': data
        })
    
    except HTTPException as e:
        raise e

    except Exception as e:
        raise HTTPException(status_code=500, detail=f"Failed to request data: {e}")