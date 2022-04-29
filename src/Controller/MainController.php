<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    /**
     * @Route("/", name="home", methods={"GET"})
     */
    public function home()
    {
        //echo "Je suis la home !";

        $response = new Response("<h1>Je suis la home !</h1>");
        return $response;
    }

    /**
     * @Route("/toto")
     */
    public function toto()
    {
        //echo "Je suis la home !";

        $response = new Response("<h1>Je suis la route toto !</h1>");
        return $response;
    }
}