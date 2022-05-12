<?php

namespace App\Controller\Front;

use DateTime;
use App\Entity\Genre;
use App\Entity\Movie;
use App\Entity\Season;
use App\Repository\MovieRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * Expérimentation Doctrine
 */

class TestController extends AbstractController
{
    /**
     * @Route("/test/genre/add", name="test_genre_add")
     */
    public function addGenre()
    {
        // On crée un objet Genre
        $fantastique = new Genre();
        // On le définit
        $fantastique->setName('Fantastique');

        dd($fantastique);
    }

    /**
     * @Route("/test/genre/{name}", name="test_genre_add")
     */
    public function readGenre($name ,ManagerRegistry $manage)
    {
        // On crée un objet Genre
        $genre = $manage->getRepository(Genre::class)->findOneBy(
            ['name' => $name]
        );


        dd($genre);
    }

    

    /**
     * Browse : lister tous les films!
     * 
     * @Route("/test/movie/browse",name="movie_browse")
     */
    public function movieBrowse(MovieRepository $movieRepository)
    {
        //on recupere tous les films depuis le Repository de Move
        $moviesList = $movieRepository->findAll();

        dd($moviesList);
    }

    /**
     * Read : recuêrer un film!
     * 
     * @Route("/test/movie/read/{id}",name="movie_read")
     */
    public function movieRead($id, MovieRepository $movieRepository)
    {
        $movie = $movieRepository->find($id);

        // todo@ gérer la 404

        dump($movie);

        return $this->render('front/test/show.html.twig',[
            'movie' => $movie,
        ]);
    }

    /**
     * Edit : editer un films!
     * 
     * @Route("/test/movie/edit/{id}",name="movie_edit")
     */
    public function movieEdit($id, ManagerRegistry $doctrine)
    {
        //1. on recupere l'objet a modifier
        $movie = $doctrine->getRepository(Movie::class)->find($id);

        // todo@ gérer la 404

        //2. on modifier la duré au hasars
        $movie->setDuration(mt_rand(30,180));

        //3. on sauvegarde
        $entityManager = $doctrine->getManager();
        // /!\ pas de persist car entité deja persisté elle a un id 
        //on la flushe
        $entityManager->flush();

        dd($movie);
    }

    /**
     * Add : ajouter un film!
     * 
     * @Route("/test/movie/add",name="movie_add")
     */
    public function movieAdd(ManagerRegistry $doctrine)
    {
        //on crée un objet de type movie
        $movie = new Movie();
        //on defiinit ses propriétés
        $movie->setTitle('Doctor Strange');
        $movie->setReleaseDate(new DateTime('2014-11-05'));
        $movie->setDuration('125');

        dump($movie);

        $entityManager = $doctrine->getManager();
        //on lui demande de persister notre entité de preparer notre requete inser
        $entityManager->persist($movie);
        //on demande d'execture la ou les requetes SQL associées
        $entityManager->flush();

        dump($movie);

                // Pour accrocher ma toolbar :D
                return new Response('</body>');
    }

    /**
     * Delete : supprimer un  film!
     * 
     * @Route("/test/movie/delete/{id}",name="movie_delete")
     */
    public function movieDelete($id, ManagerRegistry $doctrine)
    {
        $movie = $doctrine->getRepository(Movie::class)->find($id);

        // todo@ gérer la 404

        //2. on supprime
        $entityManager = $doctrine->getManager();
        // /!\ pas de persist car entité deja persisté elle a un id 
        $entityManager->remove($movie);
        //on la flushe
        $entityManager->flush();

        dd('Entité supprimé',$movie);
    }

    /**
     * Ajout d'une saison a un film existant
     * 
     * @Route("/test/season/add", name="season_add")
     */
    public function seasonAdd(ManagerRegistry $doctrine)
    {
        //on va recuperer le série X-Files
        $xFiles = $doctrine->getRepository(Movie::class)->find(5);

        //créer une saison
        $season = new Season();
        //Saison 1
        $season->setNumber(2);
        // 24 episodes
        $season->setEpisodesNumber(25);

        //L'associer a la serie voulue
        //$season->setMovie($xFiles);
        $xFiles->addSeason($season);

        //sauvagerder
        $entityManager = $doctrine->getManager();
        $entityManager->persist($season);
        $entityManager->flush(); 

        dd($season);


    }
}