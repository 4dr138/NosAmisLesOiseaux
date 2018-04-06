<?php

namespace App\Form;

use App\Entity\Users;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UsersType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, array('label' => 'Nom', 'required' => true))
            ->add('firstname', TextType::class, array('label' => 'Prénom', 'required' => true))
            ->add('username', TextType::class, array('label' => 'Pseudonyme', 'required' => true))
            ->add('mail', TextType::class, array('label' => 'E-mail', 'required' => true))
            ->add('password', TextType::class, array('label' => 'Mot de passe', 'required' => true))
            ->add('newsletter', CheckboxType::class, array('label' => 'Voulez-vous vous abonner à notre Newsletter ? ', 'required' => false))
            ->add('Valider', SubmitType::class)
            //->add('isActive')
            //->add('Role')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Users::class,
        ]);
    }
}
