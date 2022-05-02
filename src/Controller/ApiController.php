<?php

namespace App\Controller;

use App\Model\Movies;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ApiController extends AbstractController
{
    /**
     * @Route("/api/movies", name="app_api")
     */
    public function moviesCollection(): Response
    {
        $moviesModel = new Movies();
        $moviesList = $moviesModel->getAllMovies();
        return $this->json($moviesList);
    }
}
