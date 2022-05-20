<?php

namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;

/**
 * Classe qui commnunique avec l'API OMBDAPI.com
 */
class OmdbApi
{
    private $httpClient;
    private $apiKey;

    public function __construct(HttpClientInterface $httpClient, $apiKey)
    {
        $this->httpClient = $httpClient;

        $this->apiKey = $apiKey;
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
            'https://www.omdbapi.com/',
            [
                'query' => [
                    'apiKey' => 'cf1b3e9d',
                    't' => $title,
                ]
            ]
        );
        // On convertit la réponse en tableau PHP
        $content = $response->toArray();

        return $content;
    }

    /**
     * Recuper le psoter d'un film donnée
     * 
     * @param string $title movie title
     * 
     * @return string|null URL du pôster ou null si non trouvé
     */
    public function fetchPoster(string $title)
    {
        //on va chercher les infos du film
        $content = $this->fetch($title);

        //la clé poster est elle absente du contenu recu
        if(!array_key_exists('Poster', $content)) {
            return null;
        }

        return $content['Poster'];
    }
}
