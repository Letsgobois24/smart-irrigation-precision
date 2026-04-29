from fastapi import FastAPI, HTTPException, Path, Depends
from fastapi.responses import JSONResponse

from schema.node_tree import NodeTree
from schema.environment import Environment

from contextlib import asynccontextmanager
from services.mqtt.mqtt_app import startup_event
from services.mqtt.mqtt_client import client
from services.mqtt.mqtt_services import send_request, wait_to_response, send_control
from database.influxdb.influxdb_services import addGlobal, addNodeTree
from database.mariadb.mariadb_service import createDependency, toggleSystem, sendNotification
from database.mariadb.data import generate_notification
from pymysql.err import ProgrammingError
from model.prediction import predictGlobalAnomaly, predictTreeAnomaly

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
            raise HTTPException(status_code=500, detail=f"Terdapat masalah pengiriman dari device")

        response = toggleSystem(conn, is_active=order['is_active'])
        print("Response:", response)

        return JSONResponse(status_code=200, content={
            'message' : f"Device: Sistem berhasil untuk di{'hidup' if order['is_active'] else 'mati'}kan"
        })
    
    except HTTPException:
        raise

    except ProgrammingError:
        raise HTTPException(status_code=500, detail="Gagal menyimpan data")

    except Exception as e:
        raise HTTPException(status_code=500, detail=f"Gagal mengirim: {e}")

@app.get('/device/{node_id}/request_data')
def request_data(node_id: str = Path(examples=['global', 'node_1'], description='Global or unique node identifier'), conn= Depends(createDependency)):
    try:
        # Publish to device
        request_id, error = send_request(node_id, client)
        if(error):
            raise HTTPException(status_code=500, detail=f"Gagal mengirim ke device: {error}")

        # Wait response from device
        data = wait_to_response(request_id, 5)
        if (not data):
            raise HTTPException(status_code=500, detail=f"Gagal mengirim dari device")
        print("DATA:", data)
        # Save to database
        if(data['node_id'] == 'global'):
            data.pop('node_id')
            is_anomaly = predictGlobalAnomaly()
            if(is_anomaly):
                notification_data = generate_notification('global')
                print("notification_data:", notification_data)
                sendNotification(conn, data=notification_data)

            addGlobal(Environment(**data))
        else:
            is_anomaly = predictTreeAnomaly()
            if(is_anomaly):
                notification_data = generate_notification('pohon')
                sendNotification(conn, data=notification_data)

            addNodeTree(NodeTree(**data))

        if not is_anomaly: 
            message = 'Data baru berhasil ditambahkan.'
            type = 'success'
        else:
            message = 'Sistem mendeteksi kesalahan sistem. Mohon cek notifikasi'
            type = 'warning'
                   
        return JSONResponse(status_code=200, content={
            'type': type,
            'message' :  message,
        })
    
    except HTTPException as e:
        raise e
    
    except ProgrammingError:
        raise HTTPException(status_code=500, detail="Gagal menyimpan data")

    except Exception as e:
        raise HTTPException(status_code=500, detail=f"Gagal mengambil data: {e}")

