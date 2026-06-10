from pydantic import BaseModel, Field
from typing import Annotated
import time

class FaultResultSchema(BaseModel):
    node_id: Annotated[
        int,
        Field(..., examples=[1, 2, 3], description="Unique node identifier")
    ]
    
    tree_id: Annotated[
        int,
        Field(..., example=1, description="Tree ID within the node")
    ]

    global_mse: Annotated[
        float,
        Field(..., ge=0, description="Nilai Global MSE")
    ]

    fault_ratio: Annotated[
        float,
        Field(..., ge=0, le=1, description="Rasio perbandingan MSE dengan threshold")
    ]

    flag: Annotated[
        bool,
        Field(..., description="Normal atau anomali")
    ]

    dominant_feature: Annotated[
        str,
        Field(..., description="Fitur dengan MSE terbesar")
    ]

    dominant_ratio: Annotated[
        float,
        Field(..., ge=0, le=1, description="Rasio kontribusi fitur dominan terhadap total MSE")
    ]

    timestamp: Annotated[
        int,
        Field(default_factory=lambda: int(time.time() * 1000),
              description="Timestamp in milliseconds")
    ]