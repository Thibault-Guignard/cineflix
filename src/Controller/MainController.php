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
     * Affiche la page d'accueil
     * @param string $searching recherche lancé par l'utilisateur
     * 
     * @return Response
     * @Route("/search/{searching}", name="search", methods={"GET"})
     */
    public function search(string $searching): Response
    { 
    
        return $this->render('main/search.html.twig', [
            'search' => $searching,
        ]);
    }


}