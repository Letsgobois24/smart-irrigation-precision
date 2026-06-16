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

def addData(data: Dict[str, float], measurement: str, tags: list | None = None):
    df = pd.DataFrame(data=[data])
    df['time'] = convertTime(df['time'])
    client.write_dataframe(df=df, measurement=measurement, timestamp_column='time', tags=tags)
    
def extendData(df: pd.DataFrame, measurement: str, tags: list | None = None):
    df['time'] = convertTime(df['time'])
    client.write_dataframe(df=df, measurement=measurement, timestamp_column='time', tags=tags)

def convertTime(df_column):
    return pd.to_datetime(df_column, unit='ms').astype('datetime64[ms]')
