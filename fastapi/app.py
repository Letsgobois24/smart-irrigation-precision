from fastapi import FastAPI, HTTPException, Path
from fastapi.responses import JSONResponse

from schema.node_tree import NodeTree
from schema.environment import Environment

from contextlib import asynccontextmanager
from services.mqtt.mqtt_app import startup_event
from services.mqtt.mqtt_client import client
from services.mqtt.mqtt_services import send_request, wait_to_response, send_control
from database.influxdb.influxdb_services import handle_create_node, handle_create_env

import json

@asynccontextmanager
async def lifespan(app: FastAPI):
    startup_event()
    yield

app = FastAPI(lifespan=lifespan)

# Main control
@app.post('/device/global/control')
def global_control():
    try:
        request_id, error = send_control('global', client)
        
        if(error):
            raise HTTPException(status_code=500, detail=f"Terdapat masalah pengiriman dari IoT: {error}")

        # Wait response from IoT
        data = wait_to_response(request_id, 5)
        if (not data['success']):
            raise HTTPException(status_code=500, detail=f"Terdapat masalah pengiriman dari device")

        return {
            'type': 'success',
            'message' : 'Success to deactivate main valve'
        }
    except Exception as e:
        raise HTTPException(status_code=500, detail=f"Gagal mengirim: {e}")