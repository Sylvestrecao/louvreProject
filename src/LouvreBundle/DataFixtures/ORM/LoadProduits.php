<?php
// src/LouvreBundle/DataFixtures/ORM/LoadProduits.php

namespace LouvreBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use LouvreBundle\Entity\Produits;

class LoadProduits implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $produit1 = new Produits();
        $produit1->setNom("Tarif normal à partir de 12 ans");
        $produit1->setDescription("Tarif normal à partir de 12 ans à 16€");
        $produit1->setPrix('16');
        $manager->persist($produit1);

        $produit2 = new Produits();
        $produit2->setNom("Tarif « enfant » à partir de 4 ans et jusqu’à 12 ans");
        $produit2->setDescription("Tarif « enfant » à partir de 4 ans et jusqu’à 12 ans, à 8 € (l’entrée est gratuite pour les enfants de moins de 4 ans)");
        $produit2->setPrix('8');
        $manager->persist($produit2);

        $produit3 = new Produits();
        $produit3->setNom("Tarif « senior » à partir de 60 ans");
        $produit3->setDescription("Tarif « senior » à partir de 60 ans pour 12€");
        $produit3->setPrix('12');
        $manager->persist($produit3);

        $produit4 = new Produits();
        $produit4->setNom("Tarif « réduit » (étudiant, militaire…)");
        $produit4->setDescription("Tarif « réduit » de 10 € accordé dans certaines conditions (étudiant, employé du musée, d’un service du Ministère de la Culture, militaire…)");
        $produit4->setPrix('10');
        $manager->persist($produit4);

        $produit5 = new Produits();
        $produit5->setNom("Tarif « famille »");
        $produit5->setDescription("Tarif « famille » qui permet de faire entrer 2 adultes et 2 enfants ayant le même nom de famille pour 35 €");
        $produit5->setPrix('35');
        $manager->persist($produit5);

        $manager->flush();
    }
}