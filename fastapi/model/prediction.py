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
        'severity': 'high' if fault_ratio >= 1 else 'low',
        'dominant_feature': features[np.argmax(error_data)],
        'dominant_error': round(max_error, 2),
        'dominant_ratio': round(max_error / np.sum(error_data), 2),
        'prediction_time': prediction_time,
        'time': int(time.time() * 1000),
    }