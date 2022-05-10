<?php

namespace App\DataFixtures\Data;

class GenreData
{

    private $genreData = [
        'Action',
        'Animation',
        'Aventure',
        'Comédie',
        'Dessin animé',
        'Documentaire',
        'Drame',
        'Epouvante-horreur',
        'Espionnage',
        'Famille',
        'Fantastique',
        'Historique',
        'Policier',
        'Romance',
        'Science-fiction',
        'Thriller',
        'Western',
    ];

    /**
     * Get the value of genreData
     */ 
    public function getGenreData()
    {
        return $this->genreData;
    }

    public function getOneGenre($id)
    {
        return $this->genreData[$id];
    }

}