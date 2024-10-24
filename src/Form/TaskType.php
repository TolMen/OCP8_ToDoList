<?php

namespace App\Form;

use App\Entity\Task;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TaskType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Titre', // Ajout d'un label pour le champ titre
            ])
            ->add('content', TextareaType::class, [
                'label' => 'Contenu', // Ajout d'un label pour le champ contenu
            ])
            //->add('author') // Pour gérer l'utilisateur authentifié, tu peux le faire dans le contrôleur.
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Task::class, // Associer ce formulaire à l'entité Task
        ]);
    }
}
