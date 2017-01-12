<?php
// src/LouvreBundle/Validator/QuantitemaxValidator.php

namespace LouvreBundle\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Doctrine\ORM\EntityManager;
use LouvreBundle\Entity\Commandes;

class QuantitemaxValidator extends ConstraintValidator
{
    private $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    public function validate($value, Constraint $constraint)
    {
        $user_qte = $value->getQuantite();
        $jour = $value->getJour();
        
        $entities = $this->entityManager->getRepository("LouvreBundle:Commandes")->getCommandesQte($jour);
        $db_qte = implode($entities);
        $quantitemax = $db_qte + $user_qte;
        
        if($quantitemax >= Commandes::QTE_MAX){
            $this->context->addViolation($constraint->message);
        }

    }
}

