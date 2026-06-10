import random
import time

def predictGlobalAnomaly():
    return True

def predictTreeAnomaly():
    return True

def predictEventSystem(data):
    time_start = int(time.time() * 1000)
    feature = ['moisture_before', 'moisture_after', 'moisture_gain', 'moisture_rate', 'valve_duration']
    
    global_mse = round(random.uniform(0, 2), 3)
    threshold = 1
    fault_ratio = global_mse / threshold
    sleep_time = round(random.uniform(0.5, 2), 2)
    print(f"Simulating prediction time of {sleep_time} seconds...")
    time.sleep(sleep_time)
    prediction_time = int(time.time() * 1000) - time_start
    return {
        **data,
        'global_mse': global_mse,
        'fault_ratio': fault_ratio,
        'flag': fault_ratio >= 1,
        'dominant_feature': random.choice(feature),
        'dominant_ratio': round(random.uniform(50, 80), 1),
        'prediction_time': prediction_time,
        'time': int(time.time() * 1000),
    }