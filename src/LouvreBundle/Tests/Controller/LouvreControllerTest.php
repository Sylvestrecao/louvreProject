<?php

namespace LouvreBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class LouvreControllerTest extends WebTestCase
{

    public function testContact()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/contact');

        $this->assertEquals(1, $crawler->filter('h2:contains("Nous contacter")')->count());
    }

   /* public function testForm()
    {
        $client = static::createClient();
        $crawler = $client->request('POST','/coordonnees');

        $buttonCrawlerNode = $crawler->selectButton('clients_Valider');
        $form = $buttonCrawlerNode->form();

        $client->submit($form, array(
            'clients[nom]'       => 'John',
            'clients[prenom]'    => 'Doe',
            'clients[pays]'      => '5',
            'clients[birthday]'  => '11/08/1998',
            'clients[mail]'      => 'john@doe.com'
        ));
    }*/

    public function testSendMail()
    {
        $client = static::createClient();
        $crawler = $client->request('POST','/contact');

        $buttonCrawlerNode = $crawler->selectButton('contact_mail');
        $form = $buttonCrawlerNode->form();

        $client->submit($form);
    }

    public function testContent()
    {
        $client = static::createClient();
        $client->request('GET', '/');
        $this->assertContains('foo', $client->getResponse()->getContent());
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

    public function test200()
    {
        $client = static::createClient();
        $client->request('GET', '/contact');
        $this->assertEquals(
            200, // or Symfony\Component\HttpFoundation\Response::HTTP_OK
            $client->getResponse()->getStatusCode()
        );
    }

    public function testRedirect()
    {
        $client = static::createClient();
        $client->request('GET', '/panier');
        $this->assertTrue(
            $client->getResponse()->isRedirect('/')
        );
    }
    /**
     * @dataProvider urlProvider
     */
    public function testPageIsSuccessful($url)
    {
        $client = self::createClient();
        $client->request('GET', $url);

        $this->assertTrue($client->getResponse()->isSuccessful());
    }

    public function urlProvider()
    {
        return array(
            array('/'),
            array('/horaires'),
            array('/tarif'),
            array('/billeterie'),
            array('/pdf/{token}'),
            //array('/panier'),
            //array('/coordonnees'),
            //array('/paiement'),
            array('/contact'),
        );
    }

}
