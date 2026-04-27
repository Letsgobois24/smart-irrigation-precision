<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class FastAPIServices
{
    public string $url;

    public function __construct(string $url)
    {
        $this->url = $url;
    }

    public function predict($data)
    {
        $url = $this->url . '/predict';
        $response = Http::post(url: $url, data: $data);
        return $response;
    }

    public function globalControl($data)
    {
        $url = $this->url . '/device/global/control';
        $response = Http::put(url: $url, data: $data);
        return $response;
    }

    public function requestData(string $node_id)
    {
        $url = "$this->url/device/$node_id/request_data";
        $response = Http::get($url);
        return $response;
    }
}
