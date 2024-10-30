<?php

namespace App\Tests\Entity;

use App\Entity\Task;
use App\Entity\User;
use PHPUnit\Framework\TestCase;

class TaskTest extends TestCase
{
    /**
     * Teste la méthode setAuthor() et getAuthor() de la classe Task.
     *
     * Test de type : Unitaire 
     *
     * Cette méthode crée une instance de Task et une instance 
     * de User, définit l'auteur de la tâche et vérifie que 
     * l'auteur est correctement retourné par la méthode getAuthor().
     */
    public function testSetAuthorAndGetAuthor(): void
    {
        $task = new Task();
        $user = (new User())->setUsername('TestUser');
        $task->setAuthor($user);

        $this->assertSame($user, $task->getAuthor());
    }

    /**
     * Teste la définition d'un auteur anonyme pour une tâche.
     *
     * Test de type : Unitaire 
     *
     * Cette méthode crée une instance de Task avec un auteur 
     * anonyme et vérifie que le nom d'utilisateur de l'auteur 
     * est correctement enregistré et retourné.
     */
    public function testSetAuthorAsAnonymous(): void
    {
        $task = new Task();
        $anonymousUser = (new User())->setUsername('Anonyme');
        $task->setAuthor($anonymousUser);

        $this->assertEquals('Anonyme', $task->getAuthor()->getUsername());
    }

    /**
     * Teste la méthode toggle() de la classe Task.
     *
     * Test de type : Unitaire 
     *
     * Cette méthode crée une instance de Task et teste la 
     * fonctionnalité de basculement de l'état de la tâche 
     * entre fait et non fait, en vérifiant que l'état est 
     * mis à jour correctement.
     */
    public function testToggleIsDone(): void
    {
        $task = new Task();

        $this->assertFalse($task->isDone());

        $task->toggle(true);
        $this->assertTrue($task->isDone());

        $task->toggle(false);
        $this->assertFalse($task->isDone());
    }
}
