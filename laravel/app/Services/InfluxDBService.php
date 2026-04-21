<?php

namespace App\Services;

use Carbon\Carbon;
use Exception;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;

class InfluxDBService
{
    public string $token;
    public string $db;
    public string $url;
    public string $precision = 'second';
    public string $table = 'home';

    protected $result;

    public function __construct(string $url, string $token, string $db, string $precision)
    {
        $this->token = $token;
        $this->db = $db;
        $this->url = $url;
        $this->precision = $precision;
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

    public function query(string $query, bool $convertTimezone = true)
    {
        $url = $this->endpoint('/query_sql');

        /** @var Response $response */
        $response = $this->headerRequest()->post($url, [
            'db' => $this->db,
            'q' => $query
        ]);

        if ($response->failed()) {
            throw new Exception($response->body());
        }

        $this->result = $response->json();

        return $this;
    }

    public function convertTimezone(string $column = 'time')
    {
        $this->result = collect($this->result)->map(fn($value) => [...$value, $column => Carbon::parse($value[$column], 'UTC')->tz('Asia/Jakarta')]);

        return $this;
    }

    public function get()
    {
        return $this->result;
    }

    /**
     * @param array<int, array{
     *   measurement: string,
     *   tags?: array<string, string|int>,
     *   fields: array<string, int|float|string|bool>,
     *   time?: int
     * }> $rows
     */
    public function storeMultiple($rows)
    {
        $lines = [];

        foreach ($rows as $row) {
            $measurement = $row['measurement'];

            // TAGS
            $tags = '';
            if (!empty($row['tags'])) {
                $tagParts = [];
                foreach ($row['tags'] as $key => $value) {
                    $value = str_replace(' ', '\\ ', $value);
                    $tagParts[] = "$key=$value";
                }
                $tags = ',' . implode(',', $tagParts);
            }

            // FIELDS (WAJIB)
            $fieldParts = [];
            foreach ($row['fields'] as $key => $value) {
                if (is_string($value)) {
                    $value = "\"$value\"";
                } elseif (is_bool($value)) {
                    $value = $value ? 'true' : 'false';
                }
                $fieldParts[] = "$key=$value";
            }

            $fields = implode(',', $fieldParts);

            // TIMESTAMP
            $time = $row['time'] ?? now()->getTimestamp();

            $lines[] = "$measurement$tags $fields $time";
        }

        $body = implode("\n", $lines);

        $url = $this->endpoint('/write_lp', [
            'db' => $this->db,
            'precision' => $this->precision
        ]);

        $this->headerRequest()
            ->withBody($body, 'text/plain')
            ->post($url);
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
