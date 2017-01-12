<?php
// src/LouvreBundle/Validator/JourValidator.php

namespace LouvreBundle\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class JourValidator extends ConstraintValidator
{

    public function validate($value, Constraint $constraint)
    {
        $day = $value->format('D');
        $holiday1 = new \DateTime('2016/05/01');
        $holiday2 = new \DateTime('2016/11/01');
        $holiday3 = new \DateTime('2016/12/25');

       
        if ($value == $holiday1 || $value == $holiday2 || $value == $holiday3 || in_array($day, array('Tue', 'Sun'))) {
            $this->context->addViolation($constraint->message);
        }

    }
}
