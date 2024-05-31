<?php

namespace App\Services\OnOfficeApiService;

use Exception;
use Illuminate\Support\Facades\Http;

/**
 * Class Api
 */
class Api
{
    private $url = 'https://api.onoffice.de/api/';

    private $version = 'stable';

    private $key;

    private $secret;

    /**
     * Api constructor.
     */
    public function __construct(string $key, string $secret)
    {
        $this->key = $key;
        $this->secret = $secret;
    }

    public function send(AbstractRequest $request): array
    {
        $request->setSecret($this->secret);
        $request->setToken($this->key);
        try {
            $response = Http::post($this->url.$this->version.'/api.php', $request->build());
        } catch (Exception $e) {
            return [
                'error' => $e->getMessage(),
                'status_code' => 500,
            ];
        }

        if ($response->ok()) {
            return $response->json();
        } else {
            $status_code = $response->status();
            $error_message = $response->body();

            // Log the error message or handle it as needed
            return ['error' => $error_message, 'status_code' => $status_code];
        }
    }
}
