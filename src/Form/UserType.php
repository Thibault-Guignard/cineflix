<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\FormBuilderInterface;

use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email',EmailType::class,[
                'label' =>  'Adresse Email :',
            ])
            ->add('password',PasswordType::class,[
                'label'         =>  'Mot de passe',
                'help'          =>  'Au moins 8 caractères,
                                    au moins une minuscule
                                    au moins une majuscule
                                    au moins un chiffre
                                    au moins un caractère spécial parmi _, -, |, %, &, *, =, @, $',
                'constraints'   =>  [
                    new NotBlank(),
                    new Regex("^(?=.*[0-9])(?=.*[A-Z])(?=.*[a-z])(?=.*['_', '-', '|', '%', '&', '*', '=', '@', '$']).{8,}$")
                ]
            ])
            ->add('roles',ChoiceType::class,[
                'label'     => 'Quels role ?',
                'choices'   => [
                    'Administrateur'    =>  'ROLE_ADMIN',
                    'Manager'           =>  'ROLE_MANAGER',
                    'Utilisateur'       =>  'ROLE_USER',
                ],
                'multiple'  => false,
                'expanded'  => true,
                'help'      => 'Un seul choix possible'

            ])

        ;
        
        //ajout d'un data transfomer
        //pour convertir la chaine choisie en un tableau
        //qui contient cette chaine et vice versa
        $builder->get('roles')
        ->addModelTransformer(new CallbackTransformer(
            //de l'entité vers le form (affiche form)
            function ($rolesAsArray) {
                // transform the array to a string
                return implode(', ', $rolesAsArray);
            },
            //du form vers l'Entité (traite form)
            function ($rolesAsString) {
            // transform the string back to an array
                return explode(', ', $rolesAsString);
            }
        ));
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
