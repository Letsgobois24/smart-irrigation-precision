import paho.mqtt.client as paho
from paho import mqtt
import json
from data import getNodeData, getGlobalData

def on_connect(client, userdata, flags, rc, properties = None):
    print(f'Connect received with code {rc}')
    client.subscribe([("app/+/request_data", 1), ('app/global/control', 1)])

def on_subscribe(client: paho.Client, userdata, mid: int, granted_qos: list, properties=None):
    print('IoT Subscribed')

def on_message(client: paho.Client, userdata, msg: paho.MQTTMessage):
    print(f"Device -> Topik: {msg.topic}")
    
    parts = msg.topic.split('/')
    node_id = parts[1]
    action = parts[2]
    
    if node_id == 'global' and action == 'control':
        payload = json.loads(msg.payload)
        request_id = payload['request_id']
        is_active = payload['order']['is_active']
        
        client.publish(f'device/global/control', payload=json.dumps({
            'success': True,
            'request_id': request_id
        }))
        print(f"Device: Sistem berhasil untuk di{'hidup' if is_active else 'mati'}kan")
        return

    if action == 'request_data':
        request_id = msg.payload.decode('utf-8')
        print('request_id:', request_id)

        data = getGlobalData() if node_id == 'global' else getNodeData()
        data['request_id'] = request_id

        print("Data:", data)

        client.publish(f'device/{node_id}/send_data', payload=json.dumps(data))
        print("Publish:", data)
        return
    

def on_publish(client, userdata, mid, properties=None):
    print("IoT Publisheds")


client = paho.Client(
    callback_api_version=paho.CallbackAPIVersion.VERSION1, 
    client_id='IoT', 
    userdata=None, 
    protocol=paho.MQTTv5
    )
client.on_connect = on_connect

# enable TLS for secure connection
client.tls_set(tls_version=mqtt.client.ssl.PROTOCOL_TLS)
# set username and password
client.username_pw_set("letsgobois", "Letsgobois1")
# connect to HiveMQ Cloud on port 8883 (default for MQTT)
client.connect('ff6d2cce1a1947c685a845bff754d8fd.s1.eu.hivemq.cloud', port=8883)

# Setting callbacks, use separate functions like above for better visibility
client.on_subscribe = on_subscribe
client.on_message = on_message

client.loop_forever()