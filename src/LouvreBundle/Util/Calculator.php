<?php
// src/LouvreBundle/Util/Calculator.php
namespace LouvreBundle\Util;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\EntityManager;

class Calculator
{
    private $entityManager;

    public function __construct(ObjectManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function calculateQuantity($id)
    {
        $commandeRepository = $this->entityManager->getRepository('LouvreBundle:Commandes');
        $commande = $commandeRepository->find($id);
        $result = $commande->getQuantite();
        return $result;
    }

    public function getClient($id)
    {
        $clientRepository = $this->entityManager->getRepository('LouvreBundle:Clients');
        $client = $clientRepository->find($id);
        $result = $client->getNom();
        return $result;
    }
    
}