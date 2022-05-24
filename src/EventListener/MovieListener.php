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
    

    public function slugifyTitle(Movie $movie)
    {
        $movie->setSlug($this->mySlugger->slugify($movie->getTitle()));
    }
}