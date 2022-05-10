<?php

namespace App\Controller;

use App\Entity\Movie;
use App\Repository\MovieRepository;
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
    public function list(MovieRepository $movieRepository): Response
    {
        // on récupère les données depuis le modèle
        // par ordre alphabeitque
        $moviesList = $movieRepository->findBy(
            [],
            ['title' => 'ASC']
        );

        return $this->render('movie/list.html.twig',[
            'moviesList' => $moviesList,
        ]);
    }

    /**
     * Display one movie with this {id}
     *
     * @param $id
     * @return Response
     * @Route("/movie/{id}" , name="movie_show" , methods={"GET"}, requirements={"id"="\d+"})
     */
    public function show(Movie $movie): Response
    {
        
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