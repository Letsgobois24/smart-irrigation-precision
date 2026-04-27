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

    print("Add Dataframe Tree:", data_dict)

    extendData(df=df, measurement='node')

def addGlobal(data: Environment):
    data_dict = data.model_dump()
    print("Add global:", data_dict)
    addData(data=data_dict, measurement='environment')