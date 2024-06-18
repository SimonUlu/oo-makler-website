<?php

namespace App\Services\OnOffice;

use App\Services\OnOffice\Requests\AbstractRequest;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;

/**
 * Class Api
 */
class Api
{
    private string $url = 'https://api.onoffice.de/api/';

    private string $version = 'stable';

    /**
     * Api constructor.
     */
    public function __construct(private readonly string $token, private readonly string $secret)
    {
    }

    /**
     * @param  AbstractRequest|AbstractRequest[]  $requests
     */
    public function send(array|AbstractRequest $requests): array
    {
        if (empty($requests)) {
            return [];
        }

        /** @var AbstractRequest[] $requests */
        $requests = Arr::wrap($requests);

        $actions = [];
        foreach ($requests as $request) {
            $actions[] = $request->build($this->token, $this->secret);
        }

        $data = [
            'token' => $this->token,
            'request' => [
                'actions' => $actions,
            ],
        ];

        $response = Http::timeout(120)->post($this->url.$this->version.'/api.php', $data);

        if ($response->ok()) {
            return $response->json();
        }

        return [];
    }
}
