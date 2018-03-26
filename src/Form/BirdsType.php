<?php

namespace App\Form;

use App\Entity\Birds;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BirdsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('weight')
            ->add('size')
            ->add('latitude')
            ->add('observation')
            ->add('longitude')
            ->add('altitude')
            ->add('url')
            ->add('userID')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Birds::class,
        ]);
    }
}
