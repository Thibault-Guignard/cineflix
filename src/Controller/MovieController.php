<?php

namespace App\Controller;

use App\Model\Movies;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MovieController extends AbstractController
{

    /**
     * Display alls movies
     *
     * @return Response
     * @Route("/movie/list", name="movie_list")
     */
    public function list(): Response
    {
        // on récupère les données depuis le modèle
        $moviesModel = new Movies();
        $moviesList = $moviesModel->getAllMovies();   

        return $this->render('movie/list.html.twig',[
            'moviesList' => $moviesList,
        ]);
    }

    /**
     * Display one movie with this {id}
     *
     * @param integer $id
     * @return Response
     * @Route("/movie/{id}" , name="movie_show" , methods={"GET"}, requirements={"id"="\d+"})
     */
    public function show(int $id): Response
    {

        // on récupère les données depuis le modèle
        $moviesModel = new Movies();
        $movie = $moviesModel->getMovieById($id);
        
        if ($movie === null) {
            throw $this->createNotFoundException('Le film ou la série n\'existe pas');
        }

        return $this->render('movie/show.html.twig', [
            'movie' => $movie,
        ]);
    }

    /**
     * Affiche la page de resultat
     * 
     * @return Response
     * @Route("/movie/searching", name="movie_search", methods={"GET"})
     */
    public function search(): Response
    { 
    
        return $this->render('movie/searching.html.twig', [

        ]);
    }



}