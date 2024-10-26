<?php

namespace App\Tests\Entity;

use App\Entity\Task;
use App\Entity\User;
use PHPUnit\Framework\TestCase;

// Classe de test pour l'entité Task
class TaskTest extends TestCase
{
    /**
     * Teste l'attribution d'un auteur à une tâche et la récupération de cet auteur.
     *
     * Cette méthode crée une tâche et un utilisateur, puis vérifie que l'utilisateur est correctement 
     * attribué en tant qu'auteur de la tâche.
     */
    public function testSetAuthorAndGetAuthor(): void
    {
        // Crée une nouvelle tâche et un utilisateur de test
        $task = new Task();
        $user = new User();
        $user->setUsername('TestUser'); // Donne un nom d'utilisateur pour l'exemple

        // Attribue l'utilisateur créé comme auteur de la tâche
        $task->setAuthor($user);

        // Vérifie que l'auteur de la tâche correspond bien à l'utilisateur assigné
        $this->assertSame(
            $user,
            $task->getAuthor(),
            'L\'auteur de la tâche ne correspond pas à l\'utilisateur assigné.'
        );
    }

    /**
     * Teste l'attribution de l'auteur "Anonyme" pour les tâches créées sans utilisateur connecté.
     *
     * Cette méthode vérifie que si un utilisateur anonyme est défini comme auteur d'une tâche,
     * le nom d'utilisateur de l'auteur est bien "Anonyme".
     */
    public function testSetAuthorAsAnonymous(): void
    {
        // Crée une nouvelle tâche et un utilisateur "Anonyme"
        $task = new Task();
        $anonymousUser = new User();
        $anonymousUser->setUsername('Anonyme'); // Définit l'utilisateur comme étant "Anonyme"

        // Attribue l'utilisateur "Anonyme" comme auteur de la tâche
        $task->setAuthor($anonymousUser);

        // Vérifie que l'auteur de la tâche est bien "Anonyme"
        $this->assertEquals(
            'Anonyme',
            $task->getAuthor()->getUsername(),
            'L\'auteur de la tâche devrait être "Anonyme" pour les utilisateurs non connectés.'
        );
    }

    /**
     * Teste la fonction toggle() pour marquer une tâche comme terminée ou non.
     *
     * Cette méthode vérifie le fonctionnement de la méthode toggle() de l'entité Task.
     * Elle teste si une tâche peut être marquée comme terminée et vice versa.
     */
    public function testToggleIsDone(): void
    {
        // Crée une nouvelle tâche
        $task = new Task();

        // Vérifie que l'état initial de la tâche est "non terminée" (isDone = false)
        $this->assertFalse(
            $task->isDone(),
            'Une nouvelle tâche devrait être "non terminée" par défaut.'
        );

        // Change l'état de la tâche à "terminée" et vérifie
        $task->toggle(true);
        $this->assertTrue(
            $task->isDone(),
            'La tâche devrait être marquée comme terminée après l\'appel de toggle(true).'
        );

        // Change l'état de la tâche à "non terminée" et vérifie à nouveau
        $task->toggle(false);
        $this->assertFalse(
            $task->isDone(),
            'La tâche devrait être marquée comme non terminée après l\'appel de toggle(false).'
        );
    }
}
