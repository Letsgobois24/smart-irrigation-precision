import pandas as pd
from database.influxdb.influxdb_client import extendData, addData
from database.mariadb.mariadb_client import createConnection
from database.mariadb.mariadb_service import createNotification
from schema.node_tree import NodeTree, SingleTree
from schema.global_schema import GlobalSchema
from schema.system_event_schema import SystemEventSchema
from schema.fault_result_schema import FaultResultSchema
from model.prediction import predictEventSystem

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
    addData(data=data_dict, measurement='global')

def addSingleTree(data: SingleTree):
    data_dict = data.model_dump()
    addData(data=data_dict, measurement='node', tags=['tree_id', 'node_id', 'event_source'])

def addSystemEvent(data: SystemEventSchema):
    # Data for system_event table
    system_event = data.model_dump()
    addData(data=system_event, measurement='system_event', tags=['tree_id', 'node_id', 'event_id'])

    # Prediction and add to fault_result table
    prediction_result = predictEventSystem(system_event)
    addData(data=prediction_result, measurement='fault_result', tags=['tree_id', 'node_id', 'event_id'])

    # Mengirim notifikasi jika terdapat anomali
    if(True):
        try:
            conn = createConnection()
            createNotification(conn, data=prediction_result)
        finally:
            conn.close()

def addFaultResult(data: FaultResultSchema):
    addData(data=data, measurement='fault_result', tags=['tree_id', 'node_id', 'event_id'])

def addRequestData(data: dict):
    if(data['node_id'] == 'global'):
        data.pop('node_id')
        addGlobal(GlobalSchema(**data))
    else:
        addNodeTree(NodeTree(**data))