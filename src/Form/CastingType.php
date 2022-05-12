<?php

namespace App\Form;


use App\Entity\Movie;
use App\Entity\Person;
use App\Entity\Casting;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;


class CastingType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('person',EntityType::class,[
                'label' => false,
                'placeholder' => 'Sélectionnez un acteur',
                'class' => Person::class,
                'choice_label' => function($person) {
                    return $person->getName();
                }
            ])
            ->add('creditOrder',IntegerType::class,[
                'label' => "Ordre crédit"
            ])
            ->add('role',TextType::class,[
                'label' => 'Son rôle'
            ])
            ->add('movie',EntityType::class,[
                'label' => false,
                'placeholder' => 'Sélectionnez un film',
                'class' => Movie::class,
                'choice_label' => 'title',
                
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Casting::class,
            'attr' => [
                'novalidate' => 'novalidate',
            ],
        ]);
    }
}
