<?php
// src/LouvreBundle/Validator/Quantitemax.php

namespace LouvreBundle\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class Quantitemax extends Constraint
{
    public $message = "Vous ne pouvez pas commander cette quantité de billet pour ce jour, le musée est déjà plein";


    public function validatedBy()
    {
        return  'louvre_limite';
    }
    
    public function getTargets()
    {
        return self::CLASS_CONSTRAINT;
    }
}