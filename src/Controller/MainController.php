<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;

class MainController
{
    public function home()
    {
        $response = new Response('je suis la home');

        return $response;
    }
}