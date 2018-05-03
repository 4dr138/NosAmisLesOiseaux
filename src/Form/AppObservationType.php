<?php

namespace App\Form;

use App\Entity\Observation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
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
//            ->add('bird', TextType::class, array('label' => "Nom de l'oiseau croisé"))
            ->add('dateObservation', DateType::class, array('widget' => 'choice', 'label' => "Date d'observation", 'format' => 'ddMMyyyy',))
            ->add('latitude', NumberType::class)
            ->add('longitude', NumberType::class)
            ->add('comment', TextareaType::class, array('label' => "Commentaire, description de l'espèce observée, particularités..."))
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
