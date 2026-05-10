from pydantic import BaseModel, Field
from typing import Annotated
import time

class GlobalSchema(BaseModel):
    water_flow: Annotated[float | None, Field(..., ge=0 , example=10.5, description='Water flow value in ml/s')]
    main_valve: Annotated[bool | None, Field(..., example=True, description='Main valve status (1=ON, 0=OFF)')]
    time: Annotated[int, Field(default=int(time.time()), description='Timestamp in seconds')]
    ph: Annotated[float | None, Field(ge=0, le=14, description='Soil pH value at node level', example=7.4)]
