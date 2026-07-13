from http.client import HTTPException

import pandas as pd
from database.influxdb.influxdb_client import extendData, addData
from database.mariadb.mariadb_client import createConnection
from database.mariadb.mariadb_service import canSendNotification, createNotification
from schema.node_tree import NodeTree, SingleTree
from schema.global_schema import GlobalSchema
from schema.irrigation_schema import IrrigationSchema
from model.prediction import irrigationDetection
import random

def addNodeTree(data: NodeTree):
    data_dict = data.model_dump(include='trees')['trees']

    df = pd.DataFrame(data=data_dict).assign(
        node_id=data.node_id,
        time=data.time,
        event_source=data.event_source
    )

    extendData(df=df, measurement='node', tags=['tree_id', 'node_id', 'event_source'])

def addGlobal(data: GlobalSchema):
    data_dict = data.model_dump()
    data_dict['ph'] = round(random.uniform(6.5, 6.7), 2)
    addData(data=data_dict, measurement='global')

def addSingleTree(data: SingleTree):
    data_dict = data.model_dump()
    addData(data=data_dict, measurement='node', tags=['tree_id', 'node_id', 'event_source'])

def addIrrigation(data: IrrigationSchema):
    # Data for irrigation table
    irrigations = data.model_dump()
    addData(data=irrigations, measurement='irrigations', tags=['tree_id', 'node_id', 'event_id'])

    # Add data to node table for single tree update
    single_tree = {
        'node_id': irrigations['node_id'],
        'tree_id': irrigations['tree_id'],
        'soil_moisture': irrigations['moisture_after'],
        'valve': False,
        'event_source': 'event',
        'time': irrigations['time']
    }
    addSingleTree(data=SingleTree(**single_tree))

    # Prediction and add to prediction table
    prediction_result = irrigationDetection(irrigations)
    addData(data=prediction_result, measurement='predictions', tags=['tree_id', 'node_id', 'event_id'])

    # Mengirim notifikasi jika terdapat anomali
    if(not prediction_result['flag']): return
    
    try:
        conn = createConnection()
        if(canSendNotification(conn,  
            tree_id=irrigations['tree_id'], 
            feature=prediction_result['dominant_feature'], 
            severity=prediction_result['severity'], 
            hours=6)):
            createNotification(conn, data=prediction_result)
    except HTTPException as e:
        raise HTTPException(status_code=500, detail="Gagal menyimpan notifikasi ke database")
    finally:
        conn.close()

def addPeriodData(data: dict):
    if(data['node_id'] == 'global'):
        data.pop('node_id')
        addGlobal(GlobalSchema(**data))
    else:
        addNodeTree(NodeTree(**data))

def addEnergyData(data: dict):
    data = {
        "source": data["source"],
        "event": data["event"],
        "battery_soc": float(data["battery"]["soc"]),
        "battery_voltage": float(data["battery"]["voltage"]),
        "pv_power": float(data["solar"]["power"]),
        "pv_voltage": float(data["solar"]["voltage"]),
        "pv_current": float(data["solar"]["current"]),
        "load_power": float(data["load"]["power"]),
        "load_current": float(data["load"]["current"]),
        "time": data["time"]
    }
    addData(data=data, measurement='energy', tags=['source', 'event'])