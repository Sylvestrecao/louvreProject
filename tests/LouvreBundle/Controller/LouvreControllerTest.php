<?php

namespace LouvreBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class LouvreControllerTest extends WebTestCase
{

    public function testTitle(){
        $client = static::createClient();
        $crawler = $client->request('GET', '/');
        $this->assertCount(3, $crawler->filter('h2'));
    }

    public function testMainTitle(){
        $client = static::createClient();
        $crawler = $client->request('GET', '/');
        $this->assertGreaterThan(0, $crawler->filter('h1')->count());
    }

    public function testImages(){
        $client = static::createClient();
        $crawler = $client->request('GET', '/');
        $this->assertGreaterThan(0, $crawler->filter('img')->count());
    }
    
    public function testClick(){
        $client = static::createClient();
        $crawler = $client->request('GET', '/billeterie');
        $link = $crawler
            ->filter('a') // find all links with the text "Greet"
            ->link()
        ;
        $crawler = $client->click($link);
    }

    public function testContent()
    {
        $client = static::createClient();
        $client->request('GET', '/billeterie');
        $this->assertContains('Billeterie', $client->getResponse()->getContent());
    }

    public function test200All()
    {
        $client = static::createClient();
        $client->request('GET', '/');
        $this->assertTrue($client->getResponse()->isSuccessful());
    }

    public function test404()
    {
        $client = static::createClient();
        $client->request('GET', '/randompage');
        $this->assertTrue($client->getResponse()->isNotFound());
    }
    

}
