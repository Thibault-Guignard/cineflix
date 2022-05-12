<?php

namespace App\Controller;

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
     * @Route("/movie/{id}/review/add", name="review_add", methods={"GET", "POST"})
     */
    public function add(Movie $movie,ManagerRegistry $doctrine,Request $request): Response
    {
        //on l'instance de 
        $review = new Review();

        // Création du formulaire d'ajout d'une critque

        $form = $this->createForm(ReviewType::class,$review);

        $form->handleRequest($request);

        
        //si form posté on le traire
        if ($form->isSubmitted() && $form->isValid()) {
        
            //Le Formulaire a mis a jour l'entité post automatiquement

            // On va faire appel au Manager de Doctrine
            $entityManager = $doctrine->getManager();
            // Prépare-toi à "persister" notre objet (req. INSERT INTO)
            $entityManager->persist($review);

            // On exécute les requêtes SQL
            $entityManager->flush();

            //dd($review);

            // On redirige vers la liste
            return $this->redirectToRoute('movie_show', ['id' => $movie->getId()]);

        }

        //on affiche le forme
        return $this->renderForm('review/add.html.twig',[
            'form'  => $form,
            'movie' => $movie,
        ]);
    }
}
