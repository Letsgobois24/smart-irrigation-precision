import random
import time

import pandas as pd
import numpy as np
from keras.models import load_model
import joblib

# Load scaler dan model yang sudah dilatih
scaler = joblib.load('model/scaler.pkl')
model = load_model('model/best_model.keras')

features = ['moisture_after', 'moisture_before', 'moisture_gain', 'moisture_rate','valve_duration']
mse_threshold = 1.28228


def predictGlobalAnomaly():
    return True

def predictTreeAnomaly():
    return True

def predictEventSystem(data: dict):
    time_start = int(time.time() * 1000)
    
    df = pd.DataFrame([data], columns=features)
    print('Input df:', df)
    scaler_df = scaler.transform(df)
    
    # Predict the class
    recon_data = model.predict(scaler_df)
    error_data = np.abs(scaler_df - recon_data)
    mean_error = np.mean(error_data)
    fault_ratio = mean_error / mse_threshold
    max_error = np.max(error_data)
    
    prediction_time = int(time.time() * 1000) - time_start
    return {
        'event_id': data['event_id'],
        'node_id': data['node_id'],
        'tree_id': data['tree_id'],
        'global_mse': round(mean_error, 2),
        'fault_ratio': round(fault_ratio, 2),
        'flag': fault_ratio >= 1,
        'severity': getSeverity(fault_ratio),
        'dominant_feature': features[np.argmax(error_data)],
        'dominant_ratio': round(max_error / np.sum(error_data), 3),
        'dominant_error': round(max_error, 2),
        'mse_moisture_after': round(error_data[0][0], 2),
        'mse_moisture_before': round(error_data[0][1], 2),
        'mse_moisture_gain': round(error_data[0][2], 2),
        'mse_moisture_rate': round(error_data[0][3], 2),
        'mse_valve_duration': round(error_data[0][4], 2),
        'prediction_time': prediction_time,
        'time': int(time.time() * 1000),
    }

def getSeverity(fault_ratio: float):
    if fault_ratio > 2.5:
        return 'high'
    elif fault_ratio > 1.5:
        return 'medium'
    else:
        return 'low'