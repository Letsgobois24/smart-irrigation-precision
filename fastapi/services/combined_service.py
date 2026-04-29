from database.mariadb.mariadb_client import createConnection
from model.prediction import predictGlobalAnomaly, predictTreeAnomaly
from database.mariadb.data import generate_notification
from database.influxdb.influxdb_services import addGlobal, addNodeTree
from database.mariadb.mariadb_service import sendNotification
from schema.node_tree import NodeTree
from schema.environment import Environment

def mqttSavePeriodData(data: dict):
    # Save Global data
    if(data['node_id'] == 'global'):
        data.pop('node_id')
        is_anomaly = predictGlobalAnomaly()
        if(is_anomaly):
            notification_data = generate_notification('global')
            print("notification_data:", notification_data)

        addGlobal(Environment(**data))
    else:
        # Save Node data
        is_anomaly = predictTreeAnomaly()
        if(is_anomaly):
            notification_data = generate_notification('pohon')

        addNodeTree(NodeTree(**data))
    
    if(not is_anomaly): return

    # Mengirim notifikasi jika terdapat anomali
    try:
        conn = createConnection()
        sendNotification(conn, data=notification_data)
    finally:
        conn.close()