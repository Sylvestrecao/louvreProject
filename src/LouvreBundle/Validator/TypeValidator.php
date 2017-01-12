<?php
// src/LouvreBundle/Validator/TypeValidator.php

namespace LouvreBundle\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use DateTime;
class TypeValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint)
    {
        $today = new DateTime();
        $d2 = new DateTime("14:00");
        $type = $value->getType();
        $jour_reserv = $value->getJour();
        if ($type == $value->isDay() && $today >= $d2 && $today >= $jour_reserv) {
            $this->context->addViolation($constraint->message);
        }

    }
}
