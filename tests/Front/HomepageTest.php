<?php

namespace App\Tests\Front;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class HomepageTest extends WebTestCase
{
    public function testHomepageHas10Movies(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/');

        //a t on bien recu une page avec un code http 200
        $this->assertResponseIsSuccessful();
        
        //on vérifie le slogan du titre
        $this->assertSelectorTextContains('p.lead',"Où que vous soyez. Gratuit pour toujours.");
        
        //on verifier que dans le code recu il y est bien 10 films qui s'affichent
        $filteredCrawler = $crawler->filter('div.movie__poster');
        $this->assertEquals(10, count($filteredCrawler));

    }
}
