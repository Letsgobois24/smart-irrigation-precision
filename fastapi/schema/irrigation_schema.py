from pydantic import BaseModel, Field, computed_field
from typing import Annotated
import time

class IrrigationSchema(BaseModel):
    node_id: Annotated[
        int,
        Field(..., examples=[1, 2, 3], description="Unique node identifier")
    ]

    tree_id: Annotated[
        int,
        Field(..., example=1, description="Tree ID within the node")
    ]

    event_id: Annotated[
        str,
        Field(..., description="Unique event identifier")
    ]

    moisture_before: Annotated[
        float,
        Field(..., ge=0, le=100, description="Soil moisture before watering (%)")
    ]

    moisture_after: Annotated[
        float,
        Field(..., ge=0, le=100, description="Soil moisture after watering (%)")
    ]

    duration: Annotated[
        float,
        Field(..., ge=0, description="Valve open duration (seconds)")
    ]

    time: Annotated[
        int,
        Field(default_factory=lambda: int(time.time() * 1000),
              description="Timestamp in milliseconds")
    ]

    @computed_field
    @property
    def latency(self) -> int:
        return int(time.time() * 1000) - self.time

    @computed_field
    @property
    def moisture_gain(self) -> float:
        return round(self.moisture_after - self.moisture_before, 1)

    @computed_field
    @property
    def moisture_rate(self) -> float:
        return round(self.moisture_gain / self.duration, 2)