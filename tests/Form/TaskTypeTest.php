<?php

// tests/Form/TaskTypeTest.php
namespace App\Tests\Form;

use App\Entity\Task;
use App\Form\TaskType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Test\TypeTestCase;

class TaskTypeTest extends TypeTestCase
{
    public function testSubmitValidData()
    {
        // Créez un objet Task avec des données valides
        $task = new Task();
        $task->setTitle('Titre de test');
        $task->setContent('Contenu de test');

        $formData = [
            'title' => 'Titre de test',
            'content' => 'Contenu de test',
        ];

        // Créez le formulaire avec les données de test
        $form = $this->factory->create(TaskType::class, $task);

        // Soumettez le formulaire avec les données
        $form->submit($formData);

        // Vérifiez que le formulaire est valide
        $this->assertTrue($form->isSubmitted());
        $this->assertTrue($form->isValid());

        // Vérifiez que l'objet Task a bien été modifié
        $this->assertEquals('Titre de test', $task->getTitle());
        $this->assertEquals('Contenu de test', $task->getContent());
    }

    public function testBuildForm()
    {
        $form = $this->factory->create(TaskType::class);

        // Vérifiez que les bons champs sont présents dans le formulaire
        $this->assertTrue($form->has('title'));
        $this->assertTrue($form->has('content'));

        // Vérifiez le type des champs
        $this->assertInstanceOf(TextType::class, $form->get('title')->getConfig()->getType()->getInnerType());
        $this->assertInstanceOf(TextareaType::class, $form->get('content')->getConfig()->getType()->getInnerType());
    }
}
