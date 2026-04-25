import pandas as pd
from database.influxdb import extendData, addData
from schema.node_tree import NodeTree
from schema.environment import Environment

def handle_create_node(data: NodeTree):
    data_dict = data.model_dump(include='trees')['trees']
    df = pd.DataFrame(data=data_dict).assign(
        ph = data.ph,
        node_id=data.node_id,
        time=data.time
    )

    extendData(df=df, measurement='nodes')

def handle_create_env(data: Environment):
    data_dict = data.model_dump()
    print(data_dict)
    addData(data=data_dict, measurement='environment')