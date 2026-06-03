<?php

namespace App\Services;

class NodeServices
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        protected InfluxDBService $influx
    ) {}

    public function latest(array $trees)
    {
        $tree_query = implode(',', $trees);

        $query = "SELECT 
            DISTINCT ON (tree_id) * FROM node
            WHERE tree_id IN ($tree_query)
            ORDER BY tree_id, time DESC;";

        return $this->influx->query($query)->convertTimezone()->get();
    }
}
