<?php

namespace App\Controller\Back;

use App\Entity\Movie;
use App\Entity\Casting;
use App\Form\CastingType;
use App\Repository\CastingRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * Ce est un préfixe de route pour les méthodes du controller
 * @Route("/back/casting")
 */
class CastingController extends AbstractController
{
    /**
     * @Route("/movie/{id}", name="back_casting_index", methods={"GET"})
     */
    public function index(Movie $movie ,CastingRepository $castingRepository): Response
    {
        return $this->render('back/casting/index.html.twig', [
            'castings' => $castingRepository->findBy(
                ['movie' => $movie],
                ['creditOrder' => 'ASC']
            ),
            'movie' => $movie,
        ]);
    }

    /**
     * @Route("/new/movie /{id}", name="back_casting_new", methods={"GET", "POST"})
     */
    public function new(Movie $movie, Request $request, CastingRepository $castingRepository): Response
    {
        $casting = new Casting();
        $form = $this->createForm(CastingType::class, $casting);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $casting->setMovie($movie);
            $castingRepository->add($casting);
            return $this->redirectToRoute('back_casting_index', ['id' => $movie->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('back/casting/new.html.twig', [
            'casting' => $casting,
            'form' => $form,
            'movie' => $movie,
        ]);
    }

    /**
     * @Route("/{id}", name="back_casting_show", methods={"GET"})
     */
    public function show(Casting $casting): Response
    {
        return $this->render('back/casting/show.html.twig', [
            'casting' => $casting,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="back_casting_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Casting $casting, CastingRepository $castingRepository): Response
    {
        $form = $this->createForm(castingType::class, $casting);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $castingRepository->add($casting);
            $this->addFlash(
                'success',
                'Mise a jour effectué'
            );
            return $this->redirectToRoute('back_casting_index', ['id' => $casting->getMovie()->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('back/casting/edit.html.twig', [
            'casting' => $casting,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="back_casting_delete", methods={"POST"})
     */
    public function delete(Request $request, Casting $casting, CastingRepository $castingRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$casting->getId(), $request->request->get('_token'))) {
            $castingRepository->remove($casting);
            $this->addFlash(
                'success',
                'Suppresion effectué'
            );

        }

        return $this->redirectToRoute('back_casting_index', ['id' => $casting->getMovie()->getId()], Response::HTTP_SEE_OTHER);
    }
}
