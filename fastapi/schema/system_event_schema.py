from pydantic import BaseModel, Field, computed_field
from typing import Annotated
import time

class SystemEventSchema(BaseModel):
    node_id: Annotated[int, Field(..., examples=[1, 2, 3], description='Unique node identifier')]
    tree_id: Annotated[int, Field(..., example=1, description='Tree ID within the node')]
    valve: Annotated[bool | None, Field(..., description="Valve status (1=ON, 0=OFF)")]
    current_before: Annotated[float | None, Field(..., example=100, description='Electric current at time')]
    current_stable_duration: Annotated[float | None, Field(..., ge=0, description='Duration of current taking data')]
    current_stable: Annotated[float | None, Field(..., example=100, description='Electric current at time + 2s')]
    current_avg: Annotated[float | None, Field(..., example=100, description='Average electric current at time until time + 2s')]
    moisture_before: Annotated[float | None, Field(..., ge=0, le=100, description='Soil moisture at time (%)')]
    moisture_duration: Annotated[int | None, Field(..., ge=0, description='Duration of soil moisture taking data')]
    moisture_after: Annotated[float | None, Field(..., ge=0, le=100, description='Soil moisture at time + duration (%)')]
    time: Annotated[int, Field(default=int(time.time()), description='Timestamp in seconds')]

    @computed_field
    @property
    def current_delta(self) -> float:
        return round(abs(self.current_stable - self.current_before), 2)

    @computed_field
    @property
    def moisture_delta(self) -> float:
        return round(abs(self.moisture_after - self.moisture_before), 1)