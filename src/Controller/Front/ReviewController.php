<?php

namespace App\Controller\Front;

use App\Entity\Movie;
use App\Entity\Review;
use App\Form\ReviewType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ReviewController extends AbstractController
{
    /**
     * @Route("/movie/{slug}/review/add", name="review_add", methods={"GET", "POST"})
     */
    public function add(Movie $movie,ManagerRegistry $doctrine,Request $request): Response
    {

        // 404 ?
        if ($movie === null) {
            throw $this->createNotFoundException('Film non trouvé.');
        }

        //Entité Review 
        $review = new Review();

        // Création du formulaire d'ajout d'une critque Form et entité mappé dessus
        $form = $this->createForm(ReviewType::class,$review);

        //Prise en charge de la requete par le form
        $form->handleRequest($request);

        
        //si form posté on le traire
        if ($form->isSubmitted() && $form->isValid()) {
        
            //on associe le film a la review
            $review->setMovie($movie);
            //Le Formulaire a mis a jour l'entité Review automatiquement
            // On va faire appel au Manager de Doctrine
            $entityManager = $doctrine->getManager();
            // Prépare-toi à "persister" notre objet (req. INSERT INTO)
            $entityManager->persist($review);

            // On exécute les requêtes SQL
            $entityManager->flush();

            

            // On redirige vers la liste
            return $this->redirectToRoute('movie_show', ['slug' => $movie->getSlug()]);

        }

        //on affiche le forme
        return $this->renderForm('front/review/add.html.twig',[
            'form'  => $form,
            'movie' => $movie,
        ]);
    }
}
