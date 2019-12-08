<?php

namespace App\Form;

use App\Entity\Enfants;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EnfantsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('Nom', null)
            ->add('Prenom')
            ->add('Naissance')
            ->add('equipe')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Enfants::class,
        ]);
    }
}
