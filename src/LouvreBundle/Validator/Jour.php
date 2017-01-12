<?php
// src/LouvreBundle/Validator/Jour.php

namespace LouvreBundle\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class Jour extends Constraint
{
    public $message = "Vous ne pouvez pas commander de billet à cette date";
}