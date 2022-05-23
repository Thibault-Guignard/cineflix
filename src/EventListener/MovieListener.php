<?php

namespace App\EventListener;

use App\Entity\Movie;
use App\Service\MySlugger;

class MovieListener
{
    private $mySlugger;

    public function __construct(
        MySlugger $mySlugger
    ) {
        $this->mySlugger = $mySlugger;
    }
    
    public function prePersist(Movie $movie): void
    {
        $this->slugifyTitle($movie);
    }

    public function preUpdate(Movie $movie): void
    {
        $this->slugifyTitle($movie);
    }

    public function slugifyTitle(Movie $movie)
    {
        $movie->setSlug($this->mySlugger->slugify($movie->getTitle()));
    }
}