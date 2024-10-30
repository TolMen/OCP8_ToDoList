<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use App\Entity\Task;

class TaskControllerTest extends WebTestCase
{
    private $client;
    private $taskId;

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->taskId = $this->createTaskForTest();
    }

    private function loginAsAuthenticatedUser(): void
    {
        $user = [
            'username' => 'testuser',
            'password' => 'password'
        ];

        $this->client->request('POST', '/login', $user);
    }

    private function createTaskForTest(): int
    {
        $entityManager = $this->client->getContainer()->get('doctrine')->getManager();
        $task = new Task();
        $task->setTitle('Tâche de test');
        $task->setContent('Contenu de la tâche de test');
        $entityManager->persist($task);
        $entityManager->flush();
        return $task->getId();
    }

    /**
     * Teste la création d'une tâche pour un utilisateur authentifié.
     *
     * Test de type : Unitaire & Fonctionnel
     *
     * Cette méthode simule la connexion d'un utilisateur, 
     * accède à la page de création de tâche, remplit le formulaire 
     * et vérifie que l'utilisateur est redirigé vers la liste des 
     * tâches après la soumission.
     */
    public function testCreateTaskAsAuthenticatedUser(): void
    {
        $this->loginAsAuthenticatedUser();
        $crawler = $this->client->request('GET', '/tasks/create');
        $this->assertResponseIsSuccessful();
        $form = $crawler->filter('form[name="task"]')->first()->form();
        $this->assertNotNull($form, 'Le formulaire de création de tâche n\'a pas été trouvé.');
        $form['task[title]'] = 'Nouvelle tâche';
        $form['task[content]'] = 'Contenu de la tâche';
        $this->client->submit($form);
        $this->assertResponseRedirects('/tasks');
    }

    /**
     * Teste l'édition d'une tâche pour un utilisateur authentifié.
     *
     * Test de type : Unitaire & Fonctionnel
     *
     * Cette méthode simule la connexion d'un utilisateur, 
     * accède à la page d'édition d'une tâche existante, 
     * modifie les informations de la tâche et vérifie 
     * que les modifications ont été correctement enregistrées.
     */
    public function testEditTaskAsAuthenticatedUser(): void
    {
        $this->loginAsAuthenticatedUser();
        $crawler = $this->client->request('GET', '/tasks/' . $this->taskId . '/edit');
        $this->assertResponseIsSuccessful();
        $form = $crawler->filter('form[name="task"]')->first()->form();
        $this->assertNotNull($form, 'Le formulaire d\'édition de tâche n\'a pas été trouvé.');
        $form['task[title]'] = 'Tâche modifiée';
        $form['task[content]'] = 'Contenu de la tâche modifiée';
        $this->client->submit($form);
        $this->assertResponseRedirects('/tasks');
        $entityManager = $this->client->getContainer()->get('doctrine')->getManager();
        $task = $entityManager->getRepository(Task::class)->find($this->taskId);
        $this->assertEquals('Tâche modifiée', $task->getTitle(), 'Le titre de la tâche n\'a pas été mis à jour.');
    }

    /**
     * Teste l'affichage de la liste des tâches pour un utilisateur authentifié.
     *
     * Test de type : Unitaire & Fonctionnel 
     *
     * Cette méthode simule la connexion d'un utilisateur et 
     * vérifie que la page de liste des tâches est accessible 
     * et contient le titre approprié.
     */
    public function testListTasksAsAuthenticatedUser(): void
    {
        $this->loginAsAuthenticatedUser();
        $crawler = $this->client->request('GET', '/tasks');
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Liste des tâches');
    }

    /**
     * Teste la création d'une tâche sans utilisateur authentifié.
     *
     * Test de type : Unitaire & Fonctionnel 
     *
     * Cette méthode vérifie que la création d'une tâche 
     * est possible même sans authentification, et que 
     * la tâche est correctement enregistrée dans la base de données.
     */
    public function testCreateTaskWithoutAuthenticatedUser(): void
    {
        $crawler = $this->client->request('GET', '/tasks/create');
        $this->assertResponseIsSuccessful();
        $form = $crawler->filter('form[name="task"]')->first()->form();
        $this->assertNotNull($form, 'Le formulaire de création de tâche n\'a pas été trouvé.');
        $form['task[title]'] = 'Tâche test';
        $form['task[content]'] = 'Contenu de la tâche test';
        $this->client->submit($form);
        $this->assertResponseRedirects('/tasks');
        $entityManager = $this->client->getContainer()->get('doctrine')->getManager();
        $task = $entityManager->getRepository(Task::class)->findOneBy(['title' => 'Tâche test']);
        $this->assertNotNull($task, 'La tâche n\'a pas été créée.');
        $this->assertEquals('Tâche test', $task->getTitle(), 'Le titre de la tâche ne correspond pas.');
    }

    /**
     * Teste le changement de l'état d'une tâche pour un utilisateur authentifié.
     *
     * Test de type : Unitaire & Fonctionnel 
     *
     * Cette méthode simule la connexion d'un utilisateur et 
     * teste la fonctionnalité de basculement de l'état d'une tâche 
     * (faite ou non faite) et vérifie que l'état est mis à jour correctement.
     */
    public function testToggleTaskAsAuthenticatedUser(): void
    {
        $this->loginAsAuthenticatedUser();
        $this->client->request('POST', '/tasks/' . $this->taskId . '/toggle');
        $this->assertResponseRedirects('/tasks');
        $entityManager = $this->client->getContainer()->get('doctrine')->getManager();
        $task = $entityManager->getRepository(Task::class)->find($this->taskId);
        $this->assertTrue($task->isDone(), 'La tâche devrait être marquée comme faite.');
    }

    /**
     * Teste la suppression d'une tâche pour un utilisateur authentifié.
     *
     * Test de type : Unitaire & Fonctionnel
     *
     * Cette méthode simule la connexion d'un utilisateur et 
     * teste la fonctionnalité de suppression d'une tâche, 
     * puis vérifie que la tâche n'existe plus dans la base de données.
     */
    public function testDeleteTaskAsAuthenticatedUser(): void
    {
        $this->loginAsAuthenticatedUser();
        $this->client->request('POST', '/tasks/' . $this->taskId . '/delete');
        $this->assertResponseRedirects('/tasks');
        $entityManager = $this->client->getContainer()->get('doctrine')->getManager();
        $task = $entityManager->getRepository(Task::class)->find($this->taskId);
        $this->assertNull($task, 'La tâche devrait avoir été supprimée.');
    }
}
