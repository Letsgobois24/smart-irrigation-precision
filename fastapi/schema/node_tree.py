from pydantic import BaseModel, Field
from typing import Annotated, List
import time

class Tree(BaseModel):
    tree_id: Annotated[int, Field(..., example=1, description='Tree ID within the node')]
    soil_moisture: Annotated[float | None, Field(..., ge=0, le=100, description='Soil moisture (%)')]
    valve: Annotated[bool | None, Field(..., description="Valve status (1=ON, 0=OFF)")]

class NodeTree(BaseModel):
    node_id: Annotated[int, Field(examples=[1, 2, 3], description='Unique node identifier')]
    time: Annotated[int, Field(default=int(time.time()), gt=0, description='Timestamp in seconds')]
    trees: List[Tree] = Field(..., min_length=1, description='List of trees in the node', example=[
            {"tree_id": 1, "soil_moisture": 40.1, "valve": 1},
            {"tree_id": 2, "soil_moisture": 42.3, "valve": 0},
            {"tree_id": 3, "soil_moisture": 39.8, "valve": 1},
            {"tree_id": 4, "soil_moisture": 41.0, "valve": 0}
        ])

