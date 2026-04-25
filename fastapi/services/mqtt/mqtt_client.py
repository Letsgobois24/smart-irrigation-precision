import paho.mqtt.client as paho
from paho import mqtt
import os
from services.mqtt.mqtt_services import on_connect, on_message, on_publish, on_subscribe
from dotenv import load_dotenv

# Memuat semua env
load_dotenv()

BROKER = os.getenv('MQTT_BROKER')
PORT = 8883

client = paho.Client(
    callback_api_version=paho.CallbackAPIVersion.VERSION1, 
    client_id='fastapi', 
    userdata=None, 
    protocol=paho.MQTTv5
    )

# enable TLS for secure connection
client.tls_set(tls_version=mqtt.client.ssl.PROTOCOL_TLS)
# set username and password
client.username_pw_set(username=os.getenv('MQTT_USERNAME'), password=os.getenv('MQTT_PASSWORD'))

# Setting callbacks, use separate functions like above for better visibility
client.on_message = on_message
client.on_connect = on_connect
client.on_publish = on_publish
client.on_subscribe = on_subscribe