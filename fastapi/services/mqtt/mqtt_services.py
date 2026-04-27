import paho.mqtt.client as paho
import json
import uuid
import time
from typing import Tuple


pending_request = {}

def on_connect(client, userdata, flags, rc, properties = None):
    print('Connected with result code', rc)
    client.subscribe([("nodes", 1), ('environments', 1)])

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
            return
    
        # if(msg.topic == 'nodes'):
        #     data = NodeTree(**payload)
        #     handle_create_node(data=data)
        #     print('Nodes data successfully written to InfluxDB!')
        # elif(msg.topic == 'environments'):
        #     data = Environment(**payload)
        #     handle_create_env(data=data)
        #     print('Environment data successfully written to InfluxDB!')

    except Exception as e:
        print("Error:", e)

def send_request(node_id: str, client: paho.Client) -> Tuple[str, int] :
    request_id = f"{node_id}-{uuid.uuid4()}"

    pending_request[request_id] = None

    published = client.publish(f'device/{node_id}/request_data', payload=request_id)

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