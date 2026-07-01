from pydantic import BaseModel, Field
from typing import Annotated
import time

class GlobalSchema(BaseModel):
    ph: Annotated[float | None, Field(ge=0, le=14, description='Soil pH value at node level', example=7.4)]
    light: Annotated[float | None, Field(..., ge=0, le=5000, description='Light intensity value in percentage')]
    water_flow: Annotated[float | None, Field(..., ge=0 , example=10.5, description='Water flow value in ml/s')]
    water_pump: Annotated[bool | None, Field(..., example=True, description='Water pump status (1=ON, 0=OFF)')]
    fertilizer_pump: Annotated[bool | None, Field(..., example=True, description='Fertilizer pump status (1=ON, 0=OFF)')]
    time: Annotated[int, Field(default=int(time.time() * 1000), description='Timestamp in milliseconds')]
