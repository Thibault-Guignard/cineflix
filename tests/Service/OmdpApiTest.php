<?php

namespace App\Tests\Service;

use App\Service\OmdbApi;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class OmdpApiTest extends KernelTestCase
{
    public function testFetchPoster(): void
    {
        //comme on a besoin du container de service on démarre le noyea de Symfony dont le conteneur de service
        $kernel = self::bootKernel();

        $this->assertSame('test', $kernel->getEnvironment());
        // $routerService = static::getContainer()->get('router');
        // $myCustomService = static::getContainer()->get(CustomService::class);
        //on recupere notre service
        $omdbApi = static::getContainer()->get(OmdbApi::class);

        $poster = $omdbApi->fetchPoster('iron man');
        $this->assertSame($poster, "https://m.media-amazon.com/images/M/MV5BMTczNTI2ODUwOF5BMl5BanBnXkFtZTcwMTU0NTIzMw@@._V1_SX300.jpg");

        //vérifier qu'on a une image et la bonne

        $poster = $omdbApi->fetchPoster('iron manfdshsdfhjdgs');
        $this->assertNull($poster);
    }

    public function testFetch(): void
    {
        $kernel = self::bootKernel();

        $this->assertSame('test', $kernel->getEnvironment());
        
        $out = static::getContainer()->get(OmdbApi::class);

        $movie = $out->fetch('iron man');

        $this->assertArrayHasKey('imdbID', $movie);
        $this->assertArrayHasKey('Poster', $movie);
        
        $movie = $out->fetch('intouchargaerbvaerbgables');

        $this->assertArrayHasKey('Response', $movie);
        $this->assertSame('False', $movie['Response']);
    }
}
