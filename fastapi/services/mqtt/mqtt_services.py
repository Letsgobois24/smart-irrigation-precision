import paho.mqtt.client as paho
import json
import uuid
import time
from typing import Tuple
from database.influxdb.influxdb_services import addPeriodData, addIrrigation, addSingleTree, addSupplyData
from schema.node_tree import SingleTree
from schema.irrigation_schema import IrrigationSchema

pending_request = {}
def on_connect(client, userdata, flags, rc, properties = None):
    print('Connected with result code', rc)
    client.subscribe([
        ('device/+/send_data', 1), 
        ('device/global/control', 1), 
        ('device/+/period_data', 0),
        ('device/+/irrigation', 1),
        ('device/+/period_event', 1),
        ('energy/global/period_data', 0)
        ])
    
def on_disconnect(client, userdata, flags, rc):
    print('Disconnected with result code', rc)

def on_publish(client, userdata, mid, properties=None):
    print("FastAPI Published")

def on_subscribe(client: paho.Client, userdata, mid: int, granted_qos: list, properties=None):
    print('FastAPI Subscribed')
    print("mid:", mid)

def on_message(client: paho.Client, userdata, msg: paho.MQTTMessage):
    parts = msg.topic.split('/')
    action = parts[2]
    source = parts[1]

    print(f"App Message: {msg.topic}")
    payload = json.loads(msg.payload)
    print("Payload:", payload)

    # Action
    try:
        if(action == 'period_data' and source == 'energy'):
            addSupplyData(payload)
            return 

        if(action == 'period_data'):
            addPeriodData(payload)
            return

        if(action == 'period_event'):
            single_tree = payload.copy()
            single_tree['event_source'] = 'event'

            addSingleTree(data=SingleTree(**single_tree))
            return

        if(action == 'irrigation'):
            payload['event_id'] = f"{payload['node_id']}-{payload['tree_id']}-{payload['time']}"
            addIrrigation(data=(IrrigationSchema(**payload)))
            return

        if(action == 'send_data'):
            request_id = payload['request_id']
            pending_request[request_id] = payload
            return

        if(action == 'control'):
            request_id = payload['request_id']
            pending_request[request_id] = payload
            return
        
    except Exception as e:
        print("Error processing message:", e)
        return

def send_request(node_id: str, client: paho.Client) -> Tuple[str, int] :
    request_id = f"{node_id}-{uuid.uuid4()}"
    pending_request[request_id] = None

    published = client.publish(f'app/{node_id}/request_data', payload=request_id)

    if published.rc != paho.MQTT_ERR_SUCCESS:
        pending_request.pop(request_id)
        return None, published.rc
    
    return request_id, None

def send_control(node_id: str, order: dict, client: paho.Client):
    request_id = f"{node_id}-{uuid.uuid4()}"
    pending_request[request_id] = None

    published = client.publish(f'app/{node_id}/control', payload=json.dumps({
        'order': order,
        'request_id' : request_id
    }))

    if published.rc != paho.MQTT_ERR_SUCCESS:
        pending_request.pop(request_id)
        return None, published.rc
    
    return request_id, None

def wait_to_response(request_id: str, timeout: int = 5):
    start = time.time()

    while pending_request[request_id] is None:
        if(time.time() - start > timeout):
            return None
        
        time.sleep(0.1)

    data = pending_request[request_id]
    pending_request.pop(request_id)
    data.pop('request_id')  

    return data