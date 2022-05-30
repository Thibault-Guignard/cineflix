<?php

namespace App\Controller\Front;

use App\Entity\Movie;
use App\Model\Movies;
use App\Repository\GenreRepository;
use App\Service\FavoritesManager;
use App\Repository\MovieRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use ContainerRaU57p3\PaginatorInterface_82dac15;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
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
    public function home(
        EntityManagerInterface $em,
        PaginatorInterface $paginator,
        Request $request,
        GenreRepository $genreRepository): Response
    {
        $dql = "SELECT m FROM App\Entity\Movie m ORDER BY m.releaseDate DESC";
        $query = $em->createQuery($dql);

        $pagination = $paginator->paginate(
            $query,
            $request->query->getInt('page',1),
            10
        );

        $genreList = $genreRepository->findBy(
            [],
            ['name' => 'ASC']
        );

        return $this->render('front/main/home.html.twig',[
            'pagination' => $pagination,
            'genreList' => $genreList
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
    public function favorites(
        Request $request,
        SessionInterface $session,
        MovieRepository $movieRepository,
        FavoritesManager $favoritesManager):Response
    {
        $favorites = $session->get('favorites');

        if ($request->isMethod('POST')) {

            $movieId = $request->request->get('movie');
            $movie = $movieRepository->find($movieId);

            $added = $favoritesManager->toggle($movie);

            if ($added) {

                $this->addFlash(
                    'success',
                    $movie->getTitle() . '  a été ajouté de votre liste de favoris'
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
        // Vide la liste
        $success = $favoritesManager->empty();

        if ($success) {

            $this->addFlash(
                'success',
                'Liste de favoris vidée.'
            );

        } else {

            $this->addFlash(
                'warning',
                'La liste de favoris non vidée (contactez votre administrateur).'
            );

        }

        return $this->redirectToRoute('favorites');
    }
}