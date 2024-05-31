<?php

namespace App\Services;

use GuzzleHttp\Client;

class GoogleReviewsService
{
    private $client;

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => 'https://maps.googleapis.com/maps/api/place/',
        ]);
    }

    public function getReviews($placeId, $apiKey, $language = 'en')
    {
        $response = $this->client->get('details/json', [
            'query' => [
                'place_id' => $placeId,
                'fields' => 'review',
                'key' => $apiKey,
                'language' => $language,
            ],
        ]);

        //get status code from response
        $statusCode = $response->getStatusCode();
        // if status code is not 200, return empty array
        if ($statusCode !== 200) {
            return [];
        }

        $data = json_decode($response->getBody(), true);

        return $data['result']['reviews'] ?? [];
    }
}
