<?php

namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertContains('Welcome to Symfony', $crawler->filter('#container h1')->text());
    }

     public function testContact()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/contact');

        $this->assertEquals(1, $crawler->filter('h2:contains("Nous contacter")')->count());
    }
    
}
