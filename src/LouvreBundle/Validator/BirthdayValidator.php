<?php
// src/LouvreBundle/Validator/BirthdayvalidValidator.php

namespace LouvreBundle\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\HttpFoundation\Session\Session;
use DateTime;
class BirthdayValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint)
    {
        $session = new Session();
        if (!$session->has('panier')){
            $session->set('panier', array());
        }
        $panier = $session->get('panier');
        $tarif_id = $panier['produit_id'];

        $age = $value->getBirthday();

        if($tarif_id == 6 && $age <= $value->isTwelve()){}
        elseif($tarif_id == 7 && $age >= $value->isTwelve() && $age <= $value->isFour()){}
        elseif($tarif_id == 8 && $age <= $value->isSixty()){}
        elseif($tarif_id == 9 && $age <= $value->isSixteen()){}
        elseif($tarif_id == 10 && $age <= $value->isEighteen()){}
        else
        {
            $this->context->addViolation($constraint->message);
        }
    }
}
