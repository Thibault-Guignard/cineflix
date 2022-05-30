<?php

namespace App\Tests\Front;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

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

    public function testAdd2FavoriteFromHomepage()
    {
        $client = static::createClient();
        $crawler= $client->request('GET','/');

        //dump(count($crawler->filter('.bi-bookmark-plus')->eq(0)));
        $buttonCrawlerNode = $crawler->filter('.movie__favorite > button')->eq(0);

        $form = $buttonCrawlerNode->form();

        //on soumet le form
        $client->submit($form);
        $this->assertResponseStatusCodeSame(Response::HTTP_FOUND);

        //on suis la redirection ,
        $crawler = $client->followRedirect();
        //est ce qu'on est sur la route favoirtes

        //est ce que j'ai le flash message
        $this->assertSelectorTextContains('.alert-success', 'a été ajouté de votre liste de favoris');
        //est ce qu'il y a bien un film
    }
}
