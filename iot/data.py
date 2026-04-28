import time
import random

def getTree(tree_id: int):
  return {
    "soil_moisture": round(random.uniform(50, 80), 1),
    "tree_id": tree_id,
    "valve": random.choice([True, False])
}

def getNodeData():
  return {
      "node_id": "node_1",
      "time": time.time_ns(),
      "trees": [getTree(i) for i in range(1, 5)]
    }


def getGlobalData():
  return {
      "node_id": 'global',
      "ph": round(random.uniform(6, 8), 2),
      "water_flow": round(random.uniform(0.1, 1), 2),
      "main_valve": random.choice([True, False]),
      "time": time.time_ns()
  }