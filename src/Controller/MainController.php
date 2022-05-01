<?php

namespace App\Controller;

use App\Model\Movies;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MainController extends AbstractController
{
    /**
     * Affiche la page d'accueil
     * 
     * @return Response
     * @Route("/", name="home", methods={"GET"})
     */
    public function home(): Response
    {

        // on récupère les données depuis le modèle
        $moviesModel = new Movies();
        $moviesList = $moviesModel->getAllMovies();    
    
        return $this->render('main/home.html.twig', [
            'moviesList' => $moviesList,
        ]);
    }

    /**
     * Display one movie with this {id}
     *
     * @param integer $id
     * @return Response
     * @Route("/movie/{id}" , name="movieShow" , methods={"GET"})
     */
    public function movieShow(int $id): Response
    {
        // on récupère les données depuis le modèle
        $moviesModel = new Movies();
        $movie = $moviesModel->getMovie($id);    

        return $this->render('movie/movie.html.twig', [
            'movie' => $movie,
        ]);
    }
}