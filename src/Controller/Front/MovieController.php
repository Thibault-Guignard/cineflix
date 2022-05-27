<?php

namespace App\Controller\Front;

use App\Entity\Movie;
use App\Entity\Review;
use App\Form\ReviewType;
use Doctrine\ORM\Mapping\Id;
use App\Repository\GenreRepository;
use App\Repository\MovieRepository;
use App\Repository\ReviewRepository;
use App\Repository\CastingRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\PaginatorInterface;
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
    public function list(
        EntityManagerInterface $em,
        PaginatorInterface $paginator,
        Request $request,
        GenreRepository $genreRepository): Response
    {
        $dql = "SELECT m FROM App\Entity\Movie m ORDER BY m.title ASC";
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

        return $this->render('front/movie/list.html.twig',[
            'pagination' => $pagination,
            'genreList' => $genreList,
        ]);
    }

    /**
     * Display one movie with this {slug}
     *
     * @param $slug
     * @return Response
     * @Route("/movie/{slug}" , name="movie_show" , methods={"GET"})
     */
    public function show(
        Movie $movie = null,
        CastingRepository $castingRepository,
        ReviewRepository $reviewRepository): Response
    {

        if ($movie === null) {
            throw $this->createNotFoundException('Le film ou la série n\'existe pas');
        }

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