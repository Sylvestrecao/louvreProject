<?php
// src/LouvreBundle/Validator/Type.php

namespace LouvreBundle\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class Type extends Constraint
{
    public $message = "Vous ne pouvez plus commander de billet Journée une fois 14h passé";

    public function getTargets()
    {
        return self::CLASS_CONSTRAINT;
    }
}

