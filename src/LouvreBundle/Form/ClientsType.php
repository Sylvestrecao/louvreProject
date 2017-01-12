<?php

namespace LouvreBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ClientsType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom',  TextType::class)
            ->add('prenom', TextType::class)
            ->add('pays', ChoiceType::class, array(
                'choices' => array(
                   'Afghanistan' => 'Afghanistan',
                    'Afrique du Sud' => 'Afrique du Sud',
                    'Algérie' => 'Algérie',
                    'Allemagne' => 'Allemagne',
                    'Angola' => 'Angola',
                    'Arabie Saoudite' => 'Arabie Saoudite',
                    'Argentine' => 'Argentine',
                    'Australie' => 'Australie',
                    'Belgique' => 'Belgique',
                    'Birmanie' => 'Birmanie',
                    'Bolivie' => 'Bolivie',
                    'Botswana' => 'Botswana',
                    'Brésil' => 'Brésil',
                    'Bulgarie' => 'Bulgarie',
                    'Cameroun' => 'Cameroun',
                    'Canada' => 'Canada',
                    'Chine' => 'Chine',
                    'Colombie' => 'Colombie',
                    'Corée' => 'Corée',
                    'Croatie' => 'Croatie',
                    'Danemark' => 'Danemark',
                    'Égypte' => 'Égypte',
                    'Espagne' => 'Espagne',
                    'Estonie' => 'Estonie',
                    'États-Unis' => 'États-Unis',
                    'Éthiopie' => 'Éthiopie',
                    'Finlande' => 'Finlande',
                    'France' => 'France',
                    'Grèce' => 'Grèce',
                    'Hongrie' => 'Hongrie',
                    'Inde' => 'Inde',
                    'Indonésie' => 'Indonésie',
                    'Italie' => 'Italie',
                    'Irak' => 'Irak',
                    'Iran' => 'Iran',
                    'Irlande' => 'Irlande',
                    'Japon' => 'Japon',
                    'Kazakhstan' => 'Kazakhstan',
                    'Kenya' => 'Kenya',
                    'Libye' => 'Libye',
                    'Lituanie' => 'Lituanie',
                    'Luxembourg' => 'Luxembourg',
                    'Madagascar' => 'Madagascar',
                    'Malaisie' => 'Malaisie',
                    'Mali' => 'Mali',
                    'Malte' => 'Malte',
                    'Maroc' => 'Maroc',
                    'Mauritanie' => 'Mauritanie',
                    'Mexique' => 'Mexique',
                    'Mongolie' => 'Mongolie',
                    'Mozambique' => 'Mozambique',
                    'Namibie' => 'Namibie',
                    'Niger' => 'Niger',
                    'Nigeria' => 'Nigeria',
                    'Norvège' => 'Norvège',
                    'Pakistan' => 'Pakistan',
                    'Pays-Bas' => 'Pays-Bas',
                    'Pérou' => 'Pérou',
                    'Philippines' => 'Philippines',
                    'Portugal' => 'Portugal',
                    'Pologne' => 'Pologne',
                    'République Centrafricaine' => 'République Centrafricaine',
                    'République démocratique du Congo' => 'RC',
                    'République tchèque' => 'République tchèque',
                    'Roumanie' => 'Roumanie',
                    'Royaume-Uni' => 'Royaume-Uni',
                    'Russie' => 'Russie',
                    'Slovaquie' => 'Slovaquie',
                    'Slovénie' => 'Slovénie',
                    'Somalie' => 'Somalie',
                    'Soudan' => 'Suède',
                    'Suède' => 'Suède',
                    'Tanzanie' => 'Tanzanie',
                    'Tchad' => 'Tchad',
                    'Thaïlande' => 'Thaïlande',
                    'Turquie' => 'Turquie',
                    'Ukraine' => 'Ukraine',
                    'Venezuela' => 'Venezuela',
                    'Vietnam' => 'Vietnam',
                    'Zambie' => 'Zambie',
                    'Zimbabwe' => 'Zimbabwe'
                ),
                'preferred_choices' => array('France')
            ))
            ->add('birthday', BirthdayType::class, array(
                'widget' => 'single_text',
                'format' => 'dd/MM/yyyy',
            ))
            ->add('mail', EmailType::class)
            ->add('Valider', SubmitType::class)
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'LouvreBundle\Entity\Clients'
        ));
    }
}
