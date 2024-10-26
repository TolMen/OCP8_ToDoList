<?php

// tests/Form/TaskTypeTest.php
namespace App\Tests\Form;

use App\Entity\Task;
use App\Form\TaskType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Test\TypeTestCase;

/**
 * Teste le formulaire TaskType.
 *
 * Cette classe contient des tests pour s'assurer que le formulaire TaskType fonctionne 
 * correctement, notamment en vérifiant que les données sont bien soumises et que le formulaire est 
 * construit avec les bons champs.
 */
class TaskTypeTest extends TypeTestCase
{
    /**
     * Teste la soumission de données valides au formulaire.
     *
     * Cette méthode crée une instance de Task avec des données valides, 
     * soumet ces données via le formulaire, et vérifie que le formulaire est 
     * soumis et valide. Elle s'assure également que les données de l'objet Task 
     * sont correctement mises à jour après la soumission du formulaire.
     */
    public function testSubmitValidData()
    {
        // Créez un objet Task avec des données valides
        $task = new Task();
        $task->setTitle('Titre de test');
        $task->setContent('Contenu de test');

        // Données à soumettre dans le formulaire
        $formData = [
            'title' => 'Titre de test',
            'content' => 'Contenu de test',
        ];

        // Créez le formulaire avec les données de test
        $form = $this->factory->create(TaskType::class, $task);

        // Soumettez le formulaire avec les données
        $form->submit($formData);

        // Vérifiez que le formulaire est soumis
        $this->assertTrue($form->isSubmitted());

        // Vérifiez que le formulaire est valide
        $this->assertTrue($form->isValid());

        // Vérifiez que l'objet Task a bien été modifié
        $this->assertEquals('Titre de test', $task->getTitle());
        $this->assertEquals('Contenu de test', $task->getContent());
    }

    /**
     * Teste la construction du formulaire.
     *
     * Cette méthode vérifie que le formulaire TaskType est construit 
     * correctement. Elle s'assure que les champs 'title' et 'content' 
     * sont présents et que les types de ces champs sont corrects.
     */
    public function testBuildForm()
    {
        // Créez le formulaire TaskType
        $form = $this->factory->create(TaskType::class);

        // Vérifiez que les champs 'title' et 'content' sont présents dans le formulaire
        $this->assertTrue($form->has('title'));
        $this->assertTrue($form->has('content'));

        // Vérifiez que le type du champ 'title' est bien TextType
        $this->assertInstanceOf(TextType::class, $form->get('title')->getConfig()->getType()->getInnerType());

        // Vérifiez que le type du champ 'content' est bien TextareaType
        $this->assertInstanceOf(TextareaType::class, $form->get('content')->getConfig()->getType()->getInnerType());
    }
}
