from pydantic import BaseModel, Field
from typing import Annotated
import time

class SystemEventSchema(BaseModel):
    node_id: Annotated[int, Field(examples=[1, 2, 3], description='Unique node identifier')]
    tree_id: Annotated[int, Field(..., example=1, description='Tree ID within the node')]
    valve: Annotated[bool | None, Field(..., description="Valve status (1=ON, 0=OFF)")]
    current_before: Annotated[float | None, Field(..., example=100, description='Electric current at time')]
    current_after_2s: Annotated[float | None, Field(..., example=100, description='Electric current at time + 2s')]
    current_avg: Annotated[float | None, Field(..., example=100, description='Average electric current at time until time + 2s')]
    moisture_before: Annotated[float | None, Field(..., ge=0, le=100, description='Soil moisture at time (%)')]
    moisture_after_10m: Annotated[float | None, Field(..., ge=0, le=100, description='Soil moisture at time + 10 minutes (%)')]
    water_flow: Annotated[float | None, Field(..., ge=0 , example=10.5, description='Water flow value in ml/s')]
    duration: Annotated[int | None, Field(..., ge=0, description='Duration of taking data')]
    time: Annotated[int, Field(default=int(time.time()), description='Timestamp in seconds')]
