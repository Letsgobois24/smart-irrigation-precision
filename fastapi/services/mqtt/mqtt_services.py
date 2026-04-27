import paho.mqtt.client as paho
import json
import uuid
import time
from typing import Tuple
from schema.node_tree import NodeTree
from schema.environment import Environment
from database.influxdb.influxdb_services import addGlobal, addNodeTree

pending_request = {}
def on_connect(client, userdata, flags, rc, properties = None):
    print('Connected with result code', rc)
    client.subscribe([('device/+/send_data', 1), ('device/global/control', 1)])

def on_publish(client, userdata, mid, properties=None):
    print("FastAPI Published")

def on_subscribe(client: paho.Client, userdata, mid: int, granted_qos: list, properties=None):
    print('FastAPI Subscribed')
    print("mid:", mid)

def on_message(client: paho.Client, userdata, msg: paho.MQTTMessage):
    parts = msg.topic.split('/')
    action = parts[2]

    print(f"App Message: {msg.topic}")
    payload = json.loads(msg.payload)

    try:
        if(action == 'control'):
            request_id = payload['request_id']
            pending_request[request_id] = payload
            return

        if(action == 'send_data'):
            print("MQTT Client\n", payload)
            request_id = payload['request_id']
            pending_request[request_id] = payload

    except Exception as e:
        print("Error:", e)

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
    
    print('Pending Request:', pending_request)

    return data