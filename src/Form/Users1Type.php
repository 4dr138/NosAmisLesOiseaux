<?php

namespace App\Form;

use App\Entity\Users;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class Users1Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, array('label' => 'Nom : ', 'required' => true, ))
            ->add('firstname', TextType::class, array('label' => 'Prénom : ', 'required' => true, ))
            ->add('username', TextType::class, array('label' => 'Pseudonyme : ', 'required' => true))
            ->add('mail', EmailType::class, array('label' => 'E-mail : ', 'required' => true))
            ->add('password', TextType::class, array('label' => 'Mot de passe : ', 'required' => true))
            ->add('newsletter', CheckboxType::class, array('label' => 'Voulez-vous vous abonner à notre Newsletter ? ', 'required' => false))
            ->add('imageFile', FileType::class, array('label' => 'Ajouter/Modifier photo de profil', 'data_class' => null,'required' => false))
            ->add('Mettre a jour mes informations personnelles', SubmitType::class)
            //->add('isActive')
            //->add('roles')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Users::class,
        ]);
    }
}
