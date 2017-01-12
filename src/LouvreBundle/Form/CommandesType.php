<?php

namespace LouvreBundle\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CommandesType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $this->tarif = $options['tarif'];
        $this->tarifvalue = $options['tarif_value'];
        $builder
            ->add('type',     ChoiceType::class, array(
                'choices' => array(
                    'Journée' => 'Journée',
                    'Demi-Journée (uniquement après 14h)' => 'Demi-Journée',
                )
            ))
            ->add('produit',  ChoiceType::class,  array(
                'choices' => array(
                    $this->tarifvalue => $this->tarifvalue
                )
            ))

            ->add('jour',     DateType::class, array(
                'widget' => 'single_text',
                'html5'  => false,
                'format' => 'dd/MM/yyyy',
                'attr' => ['class' => 'datepicker'],
                

            ))
            ->add('quantite', ChoiceType::class, array(
                'choices' => array(
                    '1' => '1',
                    '2' => '2',
                    '3' => '3',
                    '4' => '4',
                    '5' => '5'
                )
            ))
            ->add('Valider', SubmitType::class)
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'LouvreBundle\Entity\Commandes',
            'tarif' => null,
            'tarif_value' => null
        ));
    }
}
