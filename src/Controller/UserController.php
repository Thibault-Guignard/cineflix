<?php

namespace App\Controller;

use App\Model\Movies;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UserController extends AbstractController
{
    /**
     * Display all favorites films for one user
     *
     * @param integer $userId identifiant of user
     * @return Response
     * @Route("/user/{userId}/favorites",name="user_favorites",methods={"GET"})
     */
    public function search(int $userId):Response
    {
        return $this->render('user/favorites.html.twig', [
            'user' => $userId,
        ]);
    }
}