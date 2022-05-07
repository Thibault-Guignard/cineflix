<?php

namespace App\Controller;

use App\Entity\Movie;
use App\Model\Movies;
use App\Repository\MovieRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MainController extends AbstractController
{
    /**
     * Affiche la page d'accueil
     * 
     * @return Response
     * @Route("/", name="home", methods={"GET"})
     */
    public function home(MovieRepository $movieRepository): Response
    {

        // on récupère les données depuis le modèle
        $moviesList = $movieRepository->findAll();  
    
        return $this->render('main/home.html.twig', [
            'moviesList' => $moviesList,
        ]);
    }

    /**
     * Changement theme
     * 
     * @Route("/theme/toggle", name="theme_toggle")
     */
    public function themeToggle(SessionInterface $session)
    {
        //on souhaite que le theme par defaut sois netlfix
        //la valeur stockéé est un booleen 
        //ici on va inverser le booleen de true a false et vice versa

        //qu'a t'on dans l'attribut de session netlixtheme
        //si non définie on veut netflix par defaut donc truz
        $netflixActive=$session->get('netflix_theme',true);

        //on va inverser ce booleen via l'operateur "not" !
        //ceci crée le toggle (true =>false false =>true)
        $netflixActive = !$netflixActive;

        //on sauvegarde en session
        $session->set('netflix_theme',$netflixActive);

        //on renvoie sur la home
        return $this->redirectToRoute('home');
    }

}