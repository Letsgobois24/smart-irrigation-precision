from fastapi import FastAPI, HTTPException, Path, Depends
from fastapi.responses import JSONResponse

from contextlib import asynccontextmanager
from services.mqtt.mqtt_app import startup_event
from services.mqtt.mqtt_client import client
from services.mqtt.mqtt_services import send_request, wait_to_response, send_control
from database.mariadb.mariadb_service import createDependency, toggleSystem, sendNotification
from pymysql.err import ProgrammingError
from services.combined_service import mqttSavePeriodData

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
def request_data(node_id: str = Path(examples=['global', 'node_1'], description='Global or unique node identifier')):
    try:
        # Publish to device
        request_id, error = send_request(node_id, client)
        if(error):
            raise HTTPException(status_code=500, detail=f"Gagal mengirim ke device: {error}")

        # Wait response from device
        data = wait_to_response(request_id, 5)
        if (not data):
            raise HTTPException(status_code=500, detail=f"Gagal mengirim dari device")
        # Save to database
        responses = mqttSavePeriodData(data=data)
        print('Save responses')

        if not responses['any_anomalies']: 
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

