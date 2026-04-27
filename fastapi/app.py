from fastapi import FastAPI, HTTPException, Path
from fastapi.responses import JSONResponse

from schema.node_tree import NodeTree
from schema.environment import Environment

from contextlib import asynccontextmanager
from services.mqtt.mqtt_app import startup_event
from services.mqtt.mqtt_client import client
from services.mqtt.mqtt_services import send_request, wait_to_response, send_control
from database.influxdb.influxdb_services import handle_create_node, handle_create_env
from database.mariadb.mariadb_service import getConfiguration

import json

@asynccontextmanager
async def lifespan(app: FastAPI):
    startup_event()
    yield

app = FastAPI(lifespan=lifespan)

# Main control
@app.put('/device/global/control')
def global_control(order: dict):
    try:
        request_id, error = send_control('global', order, client=client)
        
        if(error):
            raise HTTPException(status_code=500, detail=f"Terdapat masalah pengiriman dari IoT: {error}")

        # Wait response from IoT
        device_data = wait_to_response(request_id, 5)
        if (not device_data):
            print('Timeout')
            raise HTTPException(status_code=500, detail=f"Terdapat masalah pengiriman dari device")

        return {
            'type': 'success',
            'message' : f"Device: Sistem berhasil untuk di{'hidup' if order['is_active'] else 'mati'}kan"
        }
    
    except HTTPException:
        raise

    except Exception as e:
        raise HTTPException(status_code=500, detail=f"Gagal mengirim: {e}")
    
@app.get('/app/configure')
def okn():
    data = getConfiguration()
    return {
        'status' : 200,
        'data': data
    }