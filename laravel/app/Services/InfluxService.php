<?php

namespace App\Services;

use Carbon\Carbon;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;

class InfluxService
{
    public string $token;
    public string $db;
    public string $url;
    public string $table = 'home';

    public function __construct()
    {
        $this->token = config('services.influx.token');
        $this->db = config('services.influx.db');
        $this->url = config('services.influx.url');
    }

    protected function headerRequest()
    {
        return Http::withToken($this->token);
    }

    protected function endpoint(string $path, array | null $params = null)
    {
        $url = $this->url . '/api/v3' . $path;

        if (empty($params)) {
            return $url;
        }

        // Jika ada parameter
        return $url . '?' . http_build_query($params);
    }

    /**
     * @param array{room: string, hum: int, temp: int, time: int} $data
     */
    public function store(array $data): bool
    {
        $room = str_replace(' ', '\\ ', $data['room']);
        $line = sprintf("%s,room=%s temp=%s,hum=%s %s", $this->table, $room, $data['temp'], $data['hum'], $data['time'] ?? now()->getTimestamp());

        $url = $this->endpoint('/write_lp', ['db' => $this->db]);
        /** @var Response $response */
        $response = $this->headerRequest()->withBody($line, 'text/plain')->post($url);

        if ($response->failed()) {
            dd($response);
        }

        return true;
    }

    /**
     * @param array<int, array{room: string, hum: int, temp: int, time: int}> $manyData
     */
    public function storeMultiple($manyData, string | null $table = null)
    {
        $body = '';

        foreach ($manyData as $index => $data) {
            $data['room'] = str_replace(' ', '\\ ', $data['room']);
            $line = sprintf("%s,room=%s temp=%s,hum=%s %s", $table ?? $this->table, $data['room'], $data['temp'], $data['hum'], $data['time']);
            if ($index > 0) {
                $body .= "\n" . $line;
            } else {
                $body .= $line;
            }
        }

        $url = $this->endpoint('/write_lp', params: ['db' => $this->db]);
        /** @var Response $response */
        $response = $this->headerRequest()->withBody($body, 'text/plain')->post($url);

        if ($response->failed()) {
            dd($response);
        }
        dump('success');
    }

    public function query(string $query, bool $convertTimezone = true)
    {
        $url = $this->endpoint('/query_sql');

        /** @var Response $response */
        $response = $this->headerRequest()->post($url, [
            'db' => $this->db,
            'q' => $query
        ]);

        if ($response->failed()) {
            dd($response);
        }

        $data = $response->json();

        if ($convertTimezone) {
            $data = collect($data)->map(fn($value) => [...$value, 'time' => Carbon::parse($value['time'], 'UTC')->tz('Asia/Jakarta')]);
        }
        return $data;
    }

    public function createDatabase(): Response
    {
        $url = $this->endpoint('/configure/database');

        /** @var Response $response */
        $response = $this->headerRequest()->post($url, [
            'db' => $this->db
        ]);
        return $response;
    }

    public function dropDatabase()
    {
        $url = $this->endpoint('/configure/database', params: ['db' => $this->db]);

        /** @var Response $response */
        $response = $this->headerRequest()->delete($url);
        return $response;
    }

    public function configureDatabase()
    {
        $url = $this->endpoint('/configure/database');
        /** @var Response $response */
        $response = $this->headerRequest()->get($url, [
            'format' => 'json'
        ]);
        return $response;
    }
}
