<?php

namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;

/**
 * Classe qui commnunique avec l'API OMBDAPI.com
 */
class OmdbApi
{
    private $httpClient;

    public function __construct(HttpClientInterface $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    /**
     * Executer une requete pour un titre donné
     */
    public function fetch(string $title)
    {
        //on envoie une requete vers l'api
        //Cette requete contient le titre du film
        $response = $this->httpClient->request(
            'GET',
            'https://www.omdbapi.com/?t=rambo&apikey=cf1b3e9d'
        );
        // On convertit la réponse en tableau PHP
        $content = $response->toArray();

        dd($content);
    }
}
