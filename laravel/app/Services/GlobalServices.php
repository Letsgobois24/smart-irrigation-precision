<?php

namespace App\Services;

class GlobalServices
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        protected InfluxDBService $influx
    ) {}

    public function latest()
    {
        $query = "SELECT * 
                FROM 'global' 
                WHERE time <= now() + INTERVAL '7 hours'
                ORDER BY TIME DESC 
                LIMIT 1";
        return $this->influx->query($query)->convertTimezone()->get()[0];
    }
}
