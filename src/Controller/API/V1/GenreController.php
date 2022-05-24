<?php

namespace App\Controller\API\V1;

use App\Entity\Genre;
use App\Entity\Movie;
use App\Repository\GenreRepository;
use App\Repository\MovieRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * Classe qui s'occupe des ressources de type Movie
 * 
 * @Route("/api/v1" , name="api_v1_")
 */
class GenreController extends AbstractController
{
    /**
     * @Route("/genres", name="genres_get_collection" , methods={"GET"})
     */
    public function genresGetCollection(GenreRepository $genreRepository): Response
    {
        $genreList = $genreRepository->findAll();
        
        return $this->json($genreList, Response::HTTP_OK, [], ['groups' => 'genres_get_collection']);
    }

    /**
     * @Route("/genres/{id}/movies", name="genres_get_movies", methods={"GET"} ,requirements={"id"="\d+"})
     */
    public function getAllMovieByOneGenre(Genre $genre = null , MovieRepository $movieRepository){

        if ($genre === null) {
            return $this->json(['error' => 'Le genre n\'existe pas.'], Response::HTTP_NOT_FOUND);
        }


        $moviesList = $movieRepository->findAllMovieByNameGenre($genre->getName());

        return $this->json($moviesList,Response::HTTP_OK,[],['groups' => 'movies_get_collection']);
    }
}
