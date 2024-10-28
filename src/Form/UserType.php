<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('username', TextType::class, [
                'label' => "Nom d'utilisateur",
                'attr' => ['class' => 'form-control', 'style' => 'width: 100%;'],
            ])
            ->add('plainPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'Les deux mots de passe doivent correspondre.',
                'required' => $options['is_creation'],
                'first_options' => [
                    'label' => 'Mot de passe',
                    'attr' => ['class' => 'form-control', 'style' => 'width: 100%;'],
                ],
                'second_options' => [
                    'label' => 'Tapez le mot de passe à nouveau',
                    'attr' => ['class' => 'form-control', 'style' => 'width: 100%;'],
                ],
            ])
            ->add('email', EmailType::class, [
                'label' => 'Adresse email',
                'attr' => ['class' => 'form-control', 'style' => 'width: 100%;'],
            ])
            ->add('roles', ChoiceType::class, [
                'choices' => [
                    'Administrateur' => 'ROLE_ADMIN',
                ],
                'choice_attr' => [
                'ROLE_ADMIN' => ['style' => 'margin-left: 10px;'],
                ],
                'expanded' => true,
                'multiple' => true,
                'label' => 'Rôles (par défaut utilisateur)',
                'required' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class, // Associer ce formulaire à l'entité User
            'is_creation' => false, // Valeur par défaut
        ]);
    }
}
