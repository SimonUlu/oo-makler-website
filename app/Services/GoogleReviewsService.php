<?php

namespace App\Services;

use GuzzleHttp\Client;

class GoogleReviewsService
{
    private $client;

    private $placeId;

    private $apiKey;

    private $language;

    public function __construct($placeId, $apiKey, $language = 'en')
    {
        $this->client = new Client([
            'base_uri' => 'https://maps.googleapis.com/maps/api/place/',
        ]);
        $this->placeId = $placeId;
        $this->apiKey = $apiKey;
        $this->language = $language;
    }

    private function performRequest($fields, $array_field)
    {
        $response = $this->client->get('details/json', [
            'query' => [
                'place_id' => $this->placeId,
                'fields' => $fields,
                'key' => $this->apiKey,
                'language' => $this->language,
            ],
        ]);

        $statusCode = $response->getStatusCode();
        if ($statusCode !== 200) {
            return [];
        }

        $data = json_decode($response->getBody(), true);

        return $data['result'][$array_field] ?? [];
    }

    public function getReviews()
    {
        return $this->performRequest('review', 'reviews');
    }

    public function getRating()
    {
        return $this->performRequest('rating', 'rating');
    }

    public function getUserRatings()
    {
        return $this->performRequest('user_ratings_total', 'user_ratings_total');
    }
}
