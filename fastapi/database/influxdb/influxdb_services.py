import pandas as pd
from database.influxdb.influxdb_client import extendData, addData
from schema.node_tree import NodeTree
from schema.environment import Environment

def addNodeTree(data: NodeTree):
    data_dict = data.model_dump(include='trees')['trees']

    df = pd.DataFrame(data=data_dict).assign(
        node_id=data.node_id,
        time=data.time
    )

    extendData(df=df, measurement='node')

def addGlobal(data: Environment):
    data_dict = data.model_dump()
    addData(data=data_dict, measurement='environment')