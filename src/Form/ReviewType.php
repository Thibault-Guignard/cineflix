<?php

namespace App\Form;

use App\Entity\Review;
use Symfony\Component\Form\AbstractType;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ReviewType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('username',TextType::class)
            ->add('email',EmailType::class)
            ->add('content',TextareaType::class,[
                'label' => 'Critique'
            ])
            ->add('rating',ChoiceType::class,[
                'label'     => 'Avis', 
                'choices'   => [
                    'Excellent'         =>  5,
                    'Très Bon'          =>  4,
                    'Bon'               =>  3,
                    'Peut mieux faire'  =>  2,
                    'A éviter'          =>  1,   
                ]
            ])
            ->add('reactions',ChoiceType::class,[
                'label'     =>  'Ce film vous a fait :',
                'multiple'=>true,
                'expanded'=>true,
                'choices'=>[
                    'Rire'      =>  'Rire',
                    'Pleurer'   =>  'Pleurer',
                    'Réfléchir' =>  'Reflechir',
                    'Dormir'    =>  'Dormir',
                    'Rêver'     =>  'Rever',
                    ]
            ])
            ->add('watchedAt',DateTimeType::class, [
                'label' => "Vous avez vu le film le",
                'widget' => 'single_text',
                'input' => 'datetime_immutable',
                

            ])
            //->add('movie')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Review::class,
        ]);
    }
}
