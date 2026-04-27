from fastapi import FastAPI, HTTPException, Path, Depends
from fastapi.responses import JSONResponse

from schema.node_tree import NodeTree
from schema.environment import Environment

from contextlib import asynccontextmanager
from services.mqtt.mqtt_app import startup_event
from services.mqtt.mqtt_client import client
from services.mqtt.mqtt_services import send_request, wait_to_response, send_control
from database.influxdb.influxdb_services import addGlobal, addNodeTree
from database.influxdb.influxdb_client import getSensorData
from database.mariadb.mariadb_service import getConfiguration, createDependency, toggleSystem
from pymysql.err import ProgrammingError

import json

@asynccontextmanager
async def lifespan(app: FastAPI):
    startup_event()
    yield

app = FastAPI(lifespan=lifespan)

# Main control
@app.put('/device/global/control')
def global_control(order: dict, conn= Depends(createDependency)):
    try:
        request_id, error = send_control('global', order, client=client)
        
        if(error):
            raise HTTPException(status_code=500, detail=f"Terdapat masalah pengiriman dari IoT: {error}")

        # Wait response from IoT
        device_data = wait_to_response(request_id, 5)
        if (not device_data):
            print('Timeout')
            raise HTTPException(status_code=500, detail=f"Terdapat masalah pengiriman dari device")

        response = toggleSystem(conn, is_active=order['is_active'])
        print("Response:", response)

        return JSONResponse(status_code=200, content={
            'message' : f"Device: Sistem berhasil untuk di{'hidup' if order['is_active'] else 'mati'}kan"
        })
    
    except HTTPException:
        raise

    except ProgrammingError as e:
        code, message = e.args
        raise HTTPException(status_code=500, detail=f"Error {code}: {message}")

    except Exception as e:
        print("Type e:", type(e))
        raise HTTPException(status_code=500, detail=f"Gagal mengirim: {e}")

@app.get('/device/{node_id}/request_data')
def request_data(node_id: str = Path(examples=['global', 'node_1'], description='Global or unique node identifier')):
    try:
        # Publish to IoT
        request_id, error = send_request(node_id, client)
        if(error):
            raise HTTPException(status_code=500, detail=f"Gagal mengirim ke device: {error}")

        # Wait response from IoT
        data = wait_to_response(request_id, 5)
        if (not data):
            raise HTTPException(status_code=500, detail=f"Gagal mengirim dari device")

        # Save to database
        data.pop('request_id')

        if(data['node_id'] == 'global'):
            data.pop('node_id')
            addGlobal(Environment(**data))
        else:
            addNodeTree(NodeTree(**data))

        return JSONResponse(status_code=200, content={
            'message' : 'Berhasil mengambil data',
            'data': data
        })
    
    except HTTPException as e:
        raise e

    except Exception as e:
        raise HTTPException(status_code=500, detail=f"Gagal mengambil data: {e}")

@app.get('/app/configure')
def systemConfiguration(conn= Depends(createDependency)):
    data = getConfiguration(conn=conn)
    return {
        'status' : 200,
        'data': data
    }

@app.get('/app/en')
def systemConfiguration():
    data = getSensorData(10)
    return {
        'status' : 200,
        'data': data
    }