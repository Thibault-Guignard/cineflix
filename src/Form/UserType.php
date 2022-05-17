<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email',EmailType::class,[
                'label' => 'Adresse Email :'
            ])
            ->add('password',PasswordType::class,[
                'label' => 'Mot de passe'
            ])
            ->add('roles',ChoiceType::class,[
                'label' => 'Quels role ?',
                'choices' => [
                    'Administrateur' => 'ROLE_ADMIN',
                    'Manager' => 'ROLE_MANAGER',
                    'Utilisateur' => 'ROLE_USER',
                ],
                'multiple' => true,
                'expanded' => true,
                'help' => 'Un seul choix possible'

            ])

        ;

        // On pourrait utiliser un DataTransformer pour ne gérer
        // qu'un seul rôle dans le form, et le convertir en tableau
        // pour qu'il soit compatible avec la propriété $roles = []

        // <3 JB
        
        // $builder->get('roles')
        // ->addModelTransformer(new CallbackTransformer(
        //     function ($rolesAsArray) {
        //         // transform the array to a string
        //         return implode(', ', $rolesAsArray);
        //     },
        //     function ($rolesAsString) {
        //         // transform the string back to an array
        //         return explode(', ', $rolesAsString);
        //     }
        // ));
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'attr' => [
                'novalidate' => 'novalidate',
            ],
        ]);
    }
}
