import random
from schema.system_event_schema import SystemEventSchema

def predictGlobalAnomaly():
    return True

def predictTreeAnomaly():
    return True
    # return random.choice([True, False])

def predictEventSystem(data):
    score = round(random.uniform(0, 100))
    return {
        **data,
        'anomaly_score': score,
        'anomaly_flag': score >= 80
    }