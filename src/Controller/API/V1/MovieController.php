<?php

namespace App\Controller\API\V1;

use App\Repository\MovieRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


/**
 * Classe qui s'occupe des ressources de type Movie
 * 
 * @Route("/api/v1" , name="api_v1_")
 */
class MovieController extends AbstractController
{
    /**
     * @Route("/movies", name="movies_get_collection" , methods={"GET"})
     */
    public function moviesGetCollection(MovieRepository $movieRepository): Response
    {
        $moviesList = $movieRepository->findAll();
        
        return $this->json($moviesList,200,[],['groups' => 'movies_get_collection']);
    }
}
