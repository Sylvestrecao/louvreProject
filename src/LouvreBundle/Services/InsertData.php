<?php
// src/LouvreBundle/Services/insertData.php

namespace LouvreBundle\Services;
use Symfony\Component\HttpFoundation\Session\Session;
use LouvreBundle\Entity\Commandes;
use LouvreBundle\Entity\Clients;
use Doctrine\ORM\EntityManager;
class InsertData
{
    private $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function insertData($panier)
    {
        $session = new Session();
        $panier = $session->get('panier');

        $commandes = new Commandes();
        $commandes->setType($panier['type']);
        $commandes->setProduit($panier['produit']);
        $commandes->setJour($panier['date_reservation']);
        $commandes->setQuantite($panier['quantite']);
        $commandes->setToken($panier['token']);
        $commandes->setAmount($panier['amount']);

        $clients = new Clients();
        $clients->setNom($panier['nom']);
        $clients->setPrenom($panier['prenom']);
        $clients->setPays($panier['pays']);
        $clients->setBirthday($panier['birthday']);
        $clients->setMail($panier['email']);

        $commandes->setClients($clients);
        $this->em->persist($commandes);
        $this->em->flush();
    }
}