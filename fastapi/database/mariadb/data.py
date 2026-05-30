import random
from datetime import datetime

# ================= GLOBAL =================
global_cases = [
    {
        'source_type': 'global',
        'title': 'Sistem Irigasi Nonaktif',
        'message': 'Sistem irigasi global medium tidak aktif.',
        'recomendation': 'Aktifkan sistem melalui dashboard',
        'sensor_type': 'system',
        'severity': 'high',
        'value_range': (0, 1),
        'threshold': 1
    },
    {
        'source_type': 'global',
        'title': 'Koneksi Server Terputus',
        'message': 'Server tidak menerima data dari seluruh node.',
        'recomendation': 'Periksa koneksi jaringan utama',
        'sensor_type': 'network',
        'severity': 'high',
        'value_range': (0, 0),
        'threshold': 1
    },
    {
        'source_type': 'global',
        'title': 'Anomali Sistem Terdeteksi',
        'message': 'Pola data global tidak normal.',
        'recomendation': 'Periksa seluruh sistem dan sensor',
        'sensor_type': 'system',
        'severity': 'high',
        'value_range': (50, 100),
        'threshold': 60
    },
    {
        'source_type': 'global',
        'title': 'Konsumsi Air Tidak Normal',
        'message': 'Penggunaan air meningkat drastis.',
        'recomendation': 'Periksa kebocoran atau over-irrigation',
        'sensor_type': 'flow',
        'severity': 'medium',
        'value_range': (200, 500),
        'threshold': 300
    },
]

# ================= POHON =================
tree_cases = [
    {
        'source_type': 'tree',
        'title': 'Kelembapan Tanah Rendah',
        'message': 'Kelembapan tanah di bawah threshold.',
        'recomendation': 'Aktifkan irigasi',
        'sensor_type': 'kelembaban tanah',
        'severity': 'high',
        'value_range': (10, 40),
        'threshold': 45
    },
    {
        'source_type': 'tree',
        'title': 'Kelembapan Tanah Tinggi',
        'message': 'Tanah terlalu basah.',
        'recomendation': 'Matikan irigasi',
        'sensor_type': 'kelembaban tanah',
        'severity': 'medium',
        'value_range': (70, 95),
        'threshold': 65
    },
    {
        'source_type': 'tree',
        'title': 'Suhu Tanah Tinggi',
        'message': 'Suhu tanah terlalu tinggi.',
        'recomendation': 'Tambahkan irigasi atau shading',
        'sensor_type': 'suhu tanah',
        'severity': 'medium',
        'value_range': (35, 50),
        'threshold': 33
    },
    {
        'source_type': 'tree',
        'title': 'pH Tanah Asam',
        'message': 'pH tanah terlalu rendah.',
        'recomendation': 'Tambahkan kapur/dolomit',
        'sensor_type': 'pH tanah',
        'severity': 'medium',
        'value_range': (3, 5),
        'threshold': 6.5
    },
    {
        'source_type': 'tree',
        'title': 'pH Tanah Basa',
        'message': 'pH tanah terlalu tinggi.',
        'recomendation': 'Tambahkan bahan organik',
        'sensor_type': 'pH tanah',
        'severity': 'medium',
        'value_range': (8, 10),
        'threshold': 6.5
    },
    {
        'source_type': 'tree',
        'title': 'Debit Air Rendah',
        'message': 'Aliran air ke tanaman tidak mencukupi.',
        'recomendation': 'Periksa saluran atau pompa',
        'sensor_type': 'flow meter',
        'severity': 'high',
        'value_range': (5, 15),
        'threshold': 20
    },
    {
        'source_type': 'tree',
        'title': 'Tanaman Stres Kekeringan',
        'message': 'Indikasi kekurangan air pada tanaman.',
        'recomendation': 'Segera lakukan irigasi',
        'sensor_type': 'vegetation index',
        'severity': 'high',
        'value_range': (0, 30),
        'threshold': 40
    },
    {
        'source_type': 'tree',
        'title': 'Kelembaban Udara Rendah',
        'message': 'Udara terlalu kering di sekitar tanaman.',
        'recomendation': 'Tambahkan penyiraman ringan',
        'sensor_type': 'kelembaban udara',
        'severity': 'low',
        'value_range': (20, 40),
        'threshold': 50
    }
]


def generate_notification(source_type: str):
    cases = global_cases if source_type == 'global' else tree_cases

    case = random.choice(cases)
    value = round(random.uniform(*case['value_range']), 2)

    # RULE FIX
    if source_type == 'global':
        node_id = None
        tree_id = None
    else:  # pohon
        node_id = random.randint(1, 2)
        tree_id = node_id * random.randint(1, 4)

    return {
        'title': case['title'],
        'message': case['message'],
        'recomendation': case['recomendation'],
        'source_type': case['source_type'],
        'sensor_type': case['sensor_type'],
        'severity': case['severity'],
        'value': value,
        'threshold': case['threshold'],
        'node_id': node_id,
        'tree_id': tree_id,
        'is_active': random.random() < 0.85,
        'is_read': random.random() < 0.4,
        'created_at': datetime.now(),
        'updated_at': datetime.now()
    }