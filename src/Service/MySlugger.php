<?php

namespace App\Service;

use Symfony\Component\String\Slugger\SluggerInterface;

/**
 * create title slug
 */
class MySlugger 
{

    private $sluggerInterface;

    public function __construct(SluggerInterface $sluggerInterface, $toLower) {
        //rapatriement du slugger de Symfony
        $this->sluggerInterface = $sluggerInterface;
        //parametre toLower si true miniscule sinon majuscule
        $this->toLower = $toLower;
    }

    public function transformToSlug($text)
    {
        if ($this->toLower) {
            return $this->sluggerInterface->slug($text)->lower();
        }

        return $this->sluggerInterface->slug($text);
    }

}