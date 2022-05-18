<?php

namespace App\Controller\Front;

use App\Entity\Movie;
use App\Model\Movies;
use App\Repository\MovieRepository;
use App\Service\FavoritesManager;
use Symfony\Component\HttpFoundation\Request;
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
        //trier oar date de sortie releaseDate
        /*         $moviesList = $movieRepository->findBy(
            [],
            ['releaseDate' => 'DESC'],
            10,
        ); */

        $moviesList = $movieRepository->findAllOrderedByRealaseDateDscDBL();
    
        return $this->render('front/main/home.html.twig', [
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

    /**
     * @Route("/favorites", name="favorites", methods={"GET", "POST"})
     */
    public function favorites(Request $request, SessionInterface $session, MovieRepository $movieRepository, FavoritesManager $favoritesManager):Response
    {
        $favorites = $session->get('favorites');

        if ($request->isMethod('POST')) {

            $movieId = $request->request->get('movie');
            $movie = $movieRepository->find($movieId);

            $added = $favoritesManager->toggle($movie);

            if ($added) {

                $this->addFlash(
                    'success',
                    $movie->getTitle() . ' -  a été ajouté de votre liste de favoris'
                );

            } else {

                $this->addFlash(
                    'warning',
                    $movie->getTitle() . ' - a été retiré de votre liste de favoris'
                );

            }

            return $this->redirectToRoute('favorites');
        } 

        return $this->render('front/main/favorites.html.twig', [
            'favorites' => $favorites,
        ]);
    }

     /**
     * @Route("/favorites/delete", name="delete_favorites", methods={"POST"})
     */
    public function deleteFavorites(FavoritesManager $favoritesManager):Response
    {
        $favoritesManager->empty();

        $this->addFlash(
            'success',
            'Liste des favoris vidée.'
        );

        return $this->redirectToRoute('favorites');

    }

}