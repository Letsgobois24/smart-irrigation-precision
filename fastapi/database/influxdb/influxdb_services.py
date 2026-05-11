import pandas as pd
from database.influxdb.influxdb_client import extendData, addData
from schema.node_tree import NodeTree
from schema.global_schema import GlobalSchema
from schema.system_event_schema import SystemEventSchema

def addNodeTree(data: NodeTree):
    data_dict = data.model_dump(include='trees')['trees']

    df = pd.DataFrame(data=data_dict).assign(
        node_id=data.node_id,
        time=data.time
    )

    extendData(df=df, measurement='node', tags=['tree_id', 'node_id'])

def addGlobal(data: GlobalSchema):
    data_dict = data.model_dump()
    addData(data=data_dict, measurement='global')

def addSystemEvent(data: SystemEventSchema):
    # Data for system_event table
    data_dict = data.model_dump()
    addData(data=data_dict, measurement='system_event', tags=['tree_id', 'node_id'])

    # Add two tree data for node table
    tree_data_before = {
        'node_id': data_dict['node_id'],
        'tree_id': data_dict['tree_id'],
        'valve': data_dict['valve'],
        'soil_moisture': data_dict['moisture_before'],
        'time': data_dict['time']
    }

    tree_data_after = {
        'node_id': data_dict['node_id'],
        'tree_id': data_dict['tree_id'],
        'valve': data_dict['valve'],
        'soil_moisture': data_dict['moisture_after_10m'],
        'time': data_dict['time'] + data_dict['duration']
    }

    df = pd.DataFrame(data=[tree_data_before, tree_data_after])
    extendData(df=df, measurement='node', tags=['tree_id', 'node_id'])
