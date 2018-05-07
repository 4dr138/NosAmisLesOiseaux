<?php

namespace App\Form;

use App\Entity\Observation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AppObservationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
//            ->add('bird', HiddenType::class, array('data' => 'abcde'))
            ->add('birdName', HiddenType::class, array('data' => 'abcde'))
            ->add('dateObservation', DateType::class, array('widget' => 'choice', 'label' => "Date d'observation : ", 'format' => 'ddMMyyyy', 'years' => range(date('Y')-100, date('Y'))))
            ->add('latitude', TextType::class)
            ->add('longitude', TextType::class)
            ->add('comment', TextareaType::class, array('label' => "Commentaire, description de l'espèce observée, particularités...", 'attr' => array('rows' => 10)))
//            ->add('user')
            ->add('imageFile', FileType::class, array('data_class' => null,'required' => false))
            ->add('Soumettre', SubmitType::class);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Observation::class,
        ]);
    }
}
