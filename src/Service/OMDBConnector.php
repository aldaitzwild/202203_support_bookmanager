<?php

namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class OMDBConnector 
{
    private $client;

    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
    }

    public function getInfosMovie(string $title): array|null
    {
        $response = $this->client->request(
            'GET',
            'http://www.omdbapi.com/?apikey=35de7488&t=' . $title
        );

        $movie = $response->toArray();

        if($movie['Response'] == 'True')
            return $movie;

        return null;
    }
}