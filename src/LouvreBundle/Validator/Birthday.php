<?php
// src/LouvreBundle/Validator/Birthday.php

namespace LouvreBundle\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class Birthday extends Constraint
{
    public $message = "Veuillez choisir le tarif correspondant à votre âge ou votre situation.";

    public function getTargets()
    {
        return self::CLASS_CONSTRAINT;
    }
}