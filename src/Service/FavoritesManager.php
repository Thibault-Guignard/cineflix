<?php

namespace App\Service;

use App\Entity\Movie;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * Manage user favorites (movies and séries ) in session
 */
class FavoritesManager
{
    /**
     * On a besoin du service 'session' on passe donc par le construteur de ce service
     */
    private $session;

    function __construct(RequestStack $requestStack) {

        $this->session = $requestStack->getSession();
    }

    /**
     * Add or remove movie in favorites List
     * 
     * @param Movie $movie
     */
    public function toggle(Movie $movie)
    {
        $favorites = $this->session->get('favorites');

        if ($favorites != null) {

            if (array_key_exists($movie->getId(), $favorites)) {

                unset($favorites[$movie->getId()]);

                $this->session->set('favorites', $favorites);

                return false;
            }
        }

        $favorites[$movie->getId()] = $movie;

        $this->session->set('favorites', $favorites);

        return true;

    }

    /**
     * Empty favorites List
     */
    public function empty()
    {
        // Si on autorise le vidage de la liste
        if ($this->emptyEnabled) {
            $this->session->remove('favorites');
            return true;
        }

        return false;
    }
}