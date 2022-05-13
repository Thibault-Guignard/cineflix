<?php

namespace App\Controller\Back;

use App\Entity\Movie;
use App\Entity\Season;
use App\Form\SeasonType;
use App\Repository\SeasonRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * Ce est un préfixe de route pour les méthodes du controller
 * @Route("/back/season")
 */
class SeasonController extends AbstractController
{
    /**
     * @Route("/movie/{id}", name="back_season_index", methods={"GET"})
     */
    public function index(Movie $movie ,SeasonRepository $seasonRepository): Response
    {
        return $this->render('back/season/index.html.twig', [
            'seasons' => $seasonRepository->findBy(
                ['movie' => $movie],
                ['number' => 'ASC'],
            ),
            'movie' => $movie
            ]);
    }

    /**
     * @Route("/new/movie/{id}", name="back_season_new", methods={"GET", "POST"})
     */
    public function new(Movie $movie,Request $request, SeasonRepository $seasonRepository): Response
    {
        $season = new Season();
        $form = $this->createForm(SeasonType::class, $season);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            //on associe le film a la saison
            $season->setMovie($movie);
            $seasonRepository->add($season);
            $this->addFlash('success','Film ajouté');
            return $this->redirectToRoute('back_season_index', ['id' => $movie->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('back/season/new.html.twig', [
            'season' => $season,
            'form' => $form,
            'movie' => $movie,
        ]);
    }

    /**
     * @Route("/{id}", name="back_season_show", methods={"GET"})
     */
    public function show(Season $season): Response
    {
        return $this->render('back/season/show.html.twig', [
            'season' => $season,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="back_season_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Season $season, SeasonRepository $seasonRepository): Response
    {
        $form = $this->createForm(SeasonType::class, $season);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $seasonRepository->add($season);
            $this->addFlash('success','Mise a jour effectué');
            return $this->redirectToRoute('back_season_index', ['id' => $season->getMovie()->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('back/season/edit.html.twig', [
            'season' => $season,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="back_season_delete", methods={"POST"})
     */
    public function delete(Request $request, Season $season, SeasonRepository $seasonRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$season->getId(), $request->request->get('_token'))) {
            $seasonRepository->remove($season);
            $this->addFlash('success','Suppresion effectué');
        }

        return $this->redirectToRoute('back_season_index', ['id' => $season->getMovie()->getId()], Response::HTTP_SEE_OTHER);
    }
}
