<?php
namespace tests\LouvreBundle\Util;

use LouvreBundle\Util\Calculator;
use LouvreBundle\Entity\Clients;
use LouvreBundle\Entity\Commandes;
use Doctrine\ORM\EntityRepository;
use Doctrine\Common\Persistence\ObjectManager;
class CalculatorTest extends \PHPUnit_Framework_TestCase
{
    public function testCalculateQuantity()
    {
        // First, mock the object to be used in the test
        $commande = $this->createMock(Commandes::class);
        $commande->expects($this->once())
            ->method('getQuantite')
            ->will($this->returnValue(3));

        // Now, mock the repository so it returns the mock of the employee
        $commandeRepository = $this
            ->getMockBuilder(EntityRepository::class)
            ->disableOriginalConstructor()
            ->getMock();
        $commandeRepository->expects($this->once())
            ->method('find')
            ->will($this->returnValue($commande));

        // Last, mock the EntityManager to return the mock of the repository
        $entityManager = $this
            ->getMockBuilder(ObjectManager::class)
            ->disableOriginalConstructor()
            ->getMock();
        $entityManager->expects($this->once())
            ->method('getRepository')
            ->will($this->returnValue($commandeRepository));

        $commandeCalculator = new Calculator($entityManager);
        $this->assertEquals(3, $commandeCalculator->calculateQuantity(1));
    }

    public function testGetClient()
    {
        // First, mock the object to be used in the test
        $client = $this->createMock(Clients::class);
        $client->expects($this->once())
            ->method('getNom')
            ->will($this->returnValue('John'));

        // Now, mock the repository so it returns the mock of the employee
        $clientRepository = $this
            ->getMockBuilder(EntityRepository::class)
            ->disableOriginalConstructor()
            ->getMock();
        $clientRepository->expects($this->once())
            ->method('find')
            ->will($this->returnValue($client));

        // Last, mock the EntityManager to return the mock of the repository
        $entityManager = $this
            ->getMockBuilder(ObjectManager::class)
            ->disableOriginalConstructor()
            ->getMock();
        $entityManager->expects($this->once())
            ->method('getRepository')
            ->will($this->returnValue($clientRepository));

        $clientCalculator = new Calculator($entityManager);
        $this->assertEquals('John', $clientCalculator->getClient(1));
    }

    public function testNewClient()
    {
        $client = new Clients();
        $client->setNom('John');
        $client->setPrenom('Doe');
        $client->setMail('john@mail.com');
        $client->setBirthday(new \DateTime());
        $client->setPays('France');

        $this->assertNotNull($client->getNom(), "Problem on client creation");
    }

    public function testNewCommande()
    {
        $commande = new Commandes();
        $client = new Clients();

        $commande->setAmount(12);
        $commande->setClients($client);
        $commande->setJour(new \DateTime());

        $this->assertEquals(12, $commande->getAmount(), "Problem on commande creation");
    }
}