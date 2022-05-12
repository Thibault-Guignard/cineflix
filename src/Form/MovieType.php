<?php

namespace App\Form;

use App\Entity\Genre;
use App\Entity\Movie;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class MovieType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title')
            ->add('type',ChoiceType::class,[
                'expanded' => true,
                'choices' => [
                    'Film' => 'Film',
                    'Série' => 'Série'
                ]
            ])
            ->add('releaseDate')
            ->add('duration')
            ->add('summary')
            ->add('synopsis')
            ->add('poster')

            ->add('genres',EntityType::class,[
                'class' => Genre::class,
                'choice_label' => 'name',
                'multiple' =>true,
                'expanded' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Movie::class,
            'attr' => [
                'novalidate' => 'novalidate',
            ],
        ]);
    }
}
