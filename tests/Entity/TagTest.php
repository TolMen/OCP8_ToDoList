<?php

namespace App\Tests\Entity;

use App\Entity\Tag;
use App\Entity\Task;
use Doctrine\Common\Collections\ArrayCollection;
use PHPUnit\Framework\TestCase;

class TagTest extends TestCase
{
    public function testSetName()
    {
        $tag = new Tag();
        $tag->setName('Test Tag');

        $this->assertEquals('Test Tag', $tag->getName());
    }

    public function testGetId()
    {
        $tag = new Tag();

        $this->assertNull($tag->getId());
    }

    public function testGetTasks()
    {
        $tag = new Tag();
        $this->assertInstanceOf(ArrayCollection::class, $tag->getTasks());
        $this->assertCount(0, $tag->getTasks());

        // Note: Since we are not modifying the Task class, we cannot add tags to a task.
        // So we skip adding tasks in this test case.
    }

    public function testAddAndRemoveTasks()
    {
        $tag = new Tag();
        $tag->setName('Test Tag');

        $task = new Task();
        $task->setTitle('Test Task');
        $task->setContent('This is a test task.');

        // Vérifier l'ajout du tag à la tâche
        $this->assertCount(0, $task->getTags()); // Au début, il n'y a pas de tags

        // Ajouter le tag à la tâche via la méthode d'ajout
        $task->addTag($tag); // Ajouter le tag à la tâche

        // Vérifier que le tag a bien été ajouté
        $this->assertCount(1, $task->getTags());
        $this->assertTrue($task->getTags()->contains($tag));

        // Enlever le tag de la tâche
        $task->removeTag($tag); // Enlever le tag de la tâche

        // Vérifier que le tag a bien été enlevé
        $this->assertCount(0, $task->getTags());
        $this->assertFalse($task->getTags()->contains($tag));
    }
}
