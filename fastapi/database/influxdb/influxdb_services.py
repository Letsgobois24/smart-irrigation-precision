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
    data_dict = data.model_dump()
    addData(data=data_dict, measurement='system_event', tags=['tree_id', 'node_id'])
