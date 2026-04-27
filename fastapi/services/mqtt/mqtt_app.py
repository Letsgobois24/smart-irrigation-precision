import threading

from services.mqtt.mqtt_client import client
from services.mqtt.mqtt_client import BROKER, PORT

def start_mqtt():
    client.connect(BROKER, PORT)
    client.loop_forever()

def startup_event():
    thread = threading.Thread(target=start_mqtt)
    thread.daemon = True
    thread.start()