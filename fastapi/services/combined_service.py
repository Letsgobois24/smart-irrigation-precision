from database.mariadb.mariadb_client import createConnection
from model.prediction import predictGlobalAnomaly, predictTreeAnomaly
from database.mariadb.data import generate_notification
from database.influxdb.influxdb_services import addGlobal, addNodeTree
from database.mariadb.mariadb_service import sendNotification
from schema.node_tree import NodeTree
from schema.global_schema import GlobalSchema

def mqttSavePeriodData(data: dict):
    # Global data
    if(data['node_id'] == 'global'):
        data.pop('node_id')
        addGlobal(GlobalSchema(**data))
    else:
        addNodeTree(NodeTree(**data))
    