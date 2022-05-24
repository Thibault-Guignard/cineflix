<?php

namespace App\Controller\API\V1;

use App\Entity\Movie;
use App\Repository\GenreRepository;
use App\Repository\MovieRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Classe qui s'occupe des ressources de type Movie
 * 
 * @Route("/api/v1" , name="api_v1_")
 */
class MovieController extends AbstractController
{
    /**
     * @Route("/movies", name="movies_get_collection" , methods={"GET"})
     */
    public function moviesGetCollection(MovieRepository $movieRepository): Response
    {
        $moviesList = $movieRepository->findAll();
        
        return $this->json($moviesList,Response::HTTP_OK,[],['groups' => 'movies_get_collection']);
    }

    /**
     * @Route("/movies/{id}", name="movies_get_item" , methods={"GET"} ,requirements={"id"="\d+"})
     * 
     * @return mixed
     */
    public function moviesGetItem(Movie $movie = null): Response
    {
        if ($movie === null) {
            return $this->json(['error' => 'Le film ou la série n\'existe pas'], Response::HTTP_NOT_FOUND);
        }

        return $this->json($movie,Response::HTTP_OK,[],['groups' => 'movies_get_item']);
    }

    /**
     * @Route("/movies/random", name="movies_get_item" , methods={"GET"})
     * 
     * @return mixed
     */
    public function moviesGetItemRandom(MovieRepository $movieRepository): Response
    {
        //$movie = $movieRepository->findOneBy(
        //    ['id' => random_int(355,370)]
        //);


        $moviesList = $movieRepository->findAll();

        $keyMovie = array_rand($moviesList,1);
        $movie=$moviesList[$keyMovie];

        if ($movie === null) {
            return $this->json(['error' => 'Le film ou la série n\'existe pas'], Response::HTTP_NOT_FOUND);
        }

        return $this->json($movie,Response::HTTP_OK,[],['groups' => 'movies_get_item']);
    }

    /**
     * @Route("/movies", name="movies_post" , methods={"POST"})
     */
    public function moviesPost(
        Request $request,
        SerializerInterface $serializer,
        ManagerRegistry $doctrine,
        ValidatorInterface $validator,
        GenreRepository $genreRepository
    ) {
        // Recuperer le contenu JSON qui se trouve dans la requete
        $jsonContent = $request->getContent();

        // On "déserialise" le contenu JSON en entité de tyope Movie
        $movie =$serializer->deserialize($jsonContent,Movie::class,'json');       
      
        // On valide l'entité
        $errors = $validator->validate($movie);
        $errorsList = [];
        if(count($errors)>0) {
            for ($i=0; $i < count($errors) ; $i++) { 

                $message = $errors->get($i)->getMessage();
                $property = $errors->get($i)->getPropertyPath();

                $errorsList[] = [
                    'propriete' => $property,
                    'message' => $message,                    
                ];
            }

            return $this->json($errorsList,Response::HTTP_CONFLICT);
        }


        //on recupere les genres
        $jsonGenre = json_decode($jsonContent,true)['genres'];
        //création removeAllGenre() pour enlever le genre null 
        $movie->removeAllGenre();

        //je parcoure les genres saisies 
        foreach ($jsonGenre as $genreMovie) {
            
            //on recupere le genre via son nom
            $newGenre = $genreRepository->findOneBy(
                ['name' => $genreMovie]
            );

            //on l'ajoute au film
            $movie->addGenre($newGenre);
        }

        // on sauvegarde en BDD
        $em = $doctrine->getManager();
        $em->persist($movie);
  
        $em->flush();

        //return $this->json(['message' => 'Film créé'],Response::HTTP_CREATED);
        return $this->redirectToRoute('movie_show',['slug'=>$movie->getSlug()],Response::HTTP_CREATED);
    }
}
