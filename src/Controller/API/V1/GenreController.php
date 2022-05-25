<?php

namespace App\Controller\API\V1;

use App\Entity\Genre;
use App\Repository\GenreRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Classe qui s'occupe des ressources de type Genre
 * 
 * @Route("/api/v1" , name="api_v1_")
 */
class GenreController extends AbstractController
{
    /**
     * @Route("/genres", name="genres_get_collection" , methods={"GET"})
     * 
     * @return JsonResponse JSON data
     */
    public function genresGetCollection(GenreRepository $genreRepository): JsonResponse
    {
        $genreList = $genreRepository->findAll();
        
        return $this->json(['genres' => $genreList], Response::HTTP_OK, [], ['groups' => 'genres_get_collection']);
    }

    /**
     * @Route("/genres/{id}/movies", name="genres_get_movies", methods={"GET"} ,requirements={"id"="\d+"})
     */
    public function getAllMovieByOneGenre(Genre $genre = null)
    {
        if ($genre === null) {
            return $this->json(['error' => 'Le genre n\'existe pas.'], Response::HTTP_NOT_FOUND);
        }

        $results = [
            'Id' => $genre->getId(),
            'Name' => $genre->getName(),
            'Movies' => $genre->getMovies(),
        ];

        return $this->json($results,Response::HTTP_OK,[],['groups' => 'movies_get_collection']);
    }


    /**
     * Autre méthode pour recuperer les films par genre , via les groups
     * 
     * @Route("/genres/{id}/moviescollection", name="genres_get_movies_collection", methods={"GET"})
     */
    public function moviesCollectionByGenre(Genre $genre = null): Response
    {
        // 404 ?
        if ($genre === null) {
            return $this->json(['error' => 'Non non non !'], Response::HTTP_NOT_FOUND);
        }

        // On affiche le genre avec ses films sassociés
        // via les groupes de sérialisation
        return $this->json($genre, Response::HTTP_OK, [], ['groups' => ['genres_get_movies_collection','movies_get_collection']]);
    }
}
