<?php

namespace App\Service;

use Symfony\Component\String\Slugger\SluggerInterface;

/**
 * create title slug
 */
class MySlugger 
{

    private $sluggerInterface;
    private $toLower;

    public function __construct(SluggerInterface $sluggerInterface, $toLower) {
        //rapatriement du slugger de Symfony
        $this->sluggerInterface = $sluggerInterface;
        //parametre toLower si true miniscule sinon majuscule
        $this->toLower = $toLower;
    }

    public function slugify($text)
    {
        $slug = $this->sluggerInterface->slug($text);

        if ($this->toLower) {
            return $this->$slug->lower();
        }

        return $this->$slug;
    }

}