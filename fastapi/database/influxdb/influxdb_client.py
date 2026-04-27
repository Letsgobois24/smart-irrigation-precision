from influxdb_client_3 import InfluxDBClient3
from dotenv import load_dotenv
import os
import pandas as pd
from typing import Dict

# Memuat semua env
load_dotenv()

client = InfluxDBClient3(
    host=os.getenv('INFLUX_URL'),
    token=os.getenv('INFLUX_TOKEN'),
    org='',
    database=os.getenv('INFLUX_DB'),
    auth_scheme="Bearer"
)

def getSensorData(limit: int):
    # Query the DataFrame from InfluxDB
    query = f"SELECT * FROM 'environment' LIMIT {limit}"
    table: pd.DataFrame = client.query_dataframe(query=query)
    print(table)
    table['time'].astype('int')
    return table.to_json(orient='records')

def addData(data: Dict[str, float], measurement: str):
    df = pd.DataFrame(data=[data])
    client.write_dataframe(df=df, measurement=measurement, timestamp_column='time')
    
def extendData(df: pd.DataFrame, measurement: str):
    client.write_dataframe(df=df, measurement=measurement, timestamp_column='time', tags=['tree_id', 'node_id'])