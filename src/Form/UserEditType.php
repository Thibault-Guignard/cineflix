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

class UserEditType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email',EmailType::class,[
                'label'         =>  'Adresse Email :',
                //valeur par defaut chaine vide 
                'empty_data'    =>  '',
            ])
            ->add('password',PasswordType::class,[
                'label'         => 'Mot de passe',
                //valeur par defaut chaine vide 
                'empty_data'    => '',
                'attr'          =>  [
                    'placeholder'   =>   'Laissez vide si inchangé' 
                    ],
                // @link https://symfony.com/doc/current/reference/forms/types/text.html#mapped
                // Ce champ de ne sera pas mappé sur l'entité automatiquement
                // la propriété $password de $user ne sera pas modifiée par le traitement du form
                'mapped'        =>  true,
            ])
            ->add('roles',ChoiceType::class,[
                'label'     =>  'Quels role ?',
                'choices'   =>  [
                    'Administrateur'    =>  'ROLE_ADMIN',
                    'Manager'           =>  'ROLE_MANAGER',
                    'Utilisateur'       =>  'ROLE_USER',
                    ],
                'multiple'  =>  false,
                'expanded'  =>  true,
                'help'      =>  'Un seul choix possible',
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
