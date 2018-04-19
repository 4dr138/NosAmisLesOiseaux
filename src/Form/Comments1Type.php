<?php

namespace App\Form;

use App\Entity\Comments;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class Comments1Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        if(isset($_SESSION['username'])) {
            $builder
                ->add('content', TextareaType::class, array('label' => 'Commentaire : ', 'required' => true, 'attr' => array('rows' => '10', 'cols' => '100')))
                ->add('submit', SubmitType::class, array('label' => 'Poster'));
        }
        else {
            $builder
                ->add('author', TextType::class, array('label' => 'Pseudonyme : '))
                ->add('content', TextareaType::class, array('label' => 'Commentaire : ', 'required' => true, 'attr' => array('rows' => '10', 'cols' => '100')))
                ->add('submit', SubmitType::class, array('label' => 'Poster'));
        }
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Comments::class,
        ]);
    }
}
