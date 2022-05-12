<?php

namespace App\Controller\Front;

use App\Entity\Movie;
use App\Entity\Review;
use App\Form\ReviewType;
use Doctrine\ORM\Mapping\Id;
use App\Repository\MovieRepository;
use App\Repository\CastingRepository;
use App\Repository\ReviewRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
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
        /* $moviesList = $movieRepository->findBy(
            [],
            ['title' => 'ASC']
        ); */

        $moviesList =$movieRepository->findAllOrderedByTitleASC();

        return $this->render('front/movie/list.html.twig',[
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
    public function show(Movie $movie, CastingRepository $castingRepository,ReviewRepository $reviewRepository): Response
    {
        
        if ($movie === null) {
            throw $this->createNotFoundException('Le film ou la série n\'existe pas');
        }

        /* $castingList = $castingRepository->findBy(
            ['movie' => $movie], 
            ['creditOrder' => 'ASC']
        ); */

        // On va chercher notre casting via notre propre requetes
        $castingList = $castingRepository->findAllByMovieJoinedToPerson($movie);

        //on va recupere les critiques du film
        $reviewsList = $reviewRepository->findBy(
            ['movie' => $movie]
        );

        return $this->render('front/movie/show.html.twig', [
            'movie'         =>  $movie,
            'castingList'   =>  $castingList,
            'reviewsList'    =>  $reviewsList, 
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
    
        return $this->render('front/searching.html.twig', [

        ]);
    }



}