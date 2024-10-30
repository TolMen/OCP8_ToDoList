<?php

namespace App\Tests\Entity;

use App\Entity\Tag;
use App\Entity\Task;
use Doctrine\Common\Collections\ArrayCollection;
use PHPUnit\Framework\TestCase;

class TagTest extends TestCase
{
    /**
     * Teste la méthode setName() de la classe Tag.
     *
     * Test de type : Unitaire 
     *
     * Cette méthode crée une instance de Tag, 
     * définit un nom et vérifie que le nom est correctement 
     * enregistré à l'aide de la méthode getName().
     */
    public function testSetName()
    {
        $tag = new Tag();
        $tag->setName('Test Tag');

        $this->assertEquals('Test Tag', $tag->getName());
    }

    /**
     * Teste la méthode getId() de la classe Tag.
     *
     * Test de type : Unitaire 
     *
     * Cette méthode crée une instance de Tag et vérifie 
     * que l'identifiant est null, car il n'a pas encore été défini.
     */
    public function testGetId()
    {
        $tag = new Tag();

        $this->assertNull($tag->getId());
    }

    /**
     * Teste la méthode getTasks() de la classe Tag.
     *
     * Test de type : Unitaire 
     *
     * Cette méthode crée une instance de Tag et vérifie 
     * que la méthode getTasks() retourne une instance 
     * d'ArrayCollection et que la collection est vide.
     */
    public function testGetTasks()
    {
        $tag = new Tag();
        $this->assertInstanceOf(ArrayCollection::class, $tag->getTasks());
        $this->assertCount(0, $tag->getTasks());
    }

    /**
     * Teste les méthodes addTag() et removeTag() de la classe Task.
     *
     * Test de type : Unitaire 
     *
     * Cette méthode crée une instance de Tag et une instance 
     * de Task, vérifie que les méthodes addTag() et removeTag() 
     * fonctionnent correctement en ajoutant et en supprimant 
     * le tag de la tâche.
     */
    public function testAddAndRemoveTasks()
    {
        $tag = new Tag();
        $tag->setName('Test Tag');

        $task = new Task();
        $task->setTitle('Test Task');
        $task->setContent('This is a test task.');

        $this->assertCount(0, $task->getTags());

        $task->addTag($tag);

        $this->assertCount(1, $task->getTags());
        $this->assertTrue($task->getTags()->contains($tag));

        $task->removeTag($tag);

        $this->assertCount(0, $task->getTags());
        $this->assertFalse($task->getTags()->contains($tag));
    }
}
