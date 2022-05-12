<?php

namespace App\Form;

use DateTime;
use App\Entity\Genre;
use App\Entity\Movie;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;

class MovieType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title',TextType::class,[
                'label' => 'Titre :'
            ])
            ->add('type',ChoiceType::class,[
                'label' => 'Est ce un film ou une série ?',
                'expanded' => true,
                'choices' => [
                    'Film' => 'Film',
                    'Série' => 'Série'
                ]
            ])
            ->add('releaseDate',DateType::class,[
                'label' => 'Date de sortie ou de première diffusion :',
                'format' => 'ddMMMMyyyy',
                'years' => range('1895', date('Y')+2),
                'data' => new \DateTime("now"),
            ])
            ->add('duration',IntegerType::class,[
                'label' => 'Durée',
                'help' => 'Durée en minute'
            ])
            ->add('summary',TextareaType::class,[
                'label' => 'Résumé',
                'help' => 'Maximun 500 charactères'
            ])
            ->add('synopsis',TextareaType::class,[
                'label' => 'Synopsis',
            ])
            ->add('poster',UrlType::class,[
                'label' => 'Affiche'
            ])

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
