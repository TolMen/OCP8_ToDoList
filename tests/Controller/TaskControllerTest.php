<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use App\Entity\Task;
use App\Entity\User;

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
     * Test de type : Unitaire
     *
     * Explication du test :
     * Cette méthode simule la connexion d'un utilisateur authentifié, 
     * accède à la page de création d'une tâche, 
     * remplit le formulaire de création, 
     * puis soumet le formulaire pour vérifier que l'utilisateur est redirigé vers la liste des tâches.
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
     * Test de type : Unitaire
     *
     * Explication du test :
     * Cette méthode simule la connexion d'un utilisateur authentifié, 
     * accède à la page d'édition d'une tâche, 
     * remplit le formulaire d'édition, 
     * puis soumet le formulaire pour vérifier que la tâche a été mise à jour dans la base de données.
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
     * Test de type : Unitaire
     *
     * Explication du test :
     * Cette méthode simule la connexion d'un utilisateur authentifié, 
     * accède à la page de liste des tâches et 
     * vérifie que la réponse est réussie et contient le titre approprié.
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
     * Test de type : Unitaire
     *
     * Explication du test :
     * Cette méthode accède à la page de création d'une tâche sans être authentifié, 
     * remplit le formulaire et soumet les données, 
     * puis vérifie que la tâche a été créée dans la base de données.
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
     * Test de type : Unitaire
     *
     * Explication du test :
     * Cette méthode simule la connexion d'un utilisateur authentifié, 
     * récupère l'état initial d'une tâche, 
     * bascule son état, 
     * puis vérifie que l'état de la tâche a été mis à jour correctement.
     */
    public function testToggleTaskAsAuthenticatedUser(): void
    {
        $this->loginAsAuthenticatedUser();
        $entityManager = $this->client->getContainer()->get('doctrine')->getManager();
        $task = $entityManager->getRepository(Task::class)->find($this->taskId);

        $initialState = $task->isDone();
        $this->client->request('POST', '/tasks/' . $this->taskId . '/toggle');
        $this->assertResponseRedirects('/tasks');

        $task = $entityManager->getRepository(Task::class)->find($this->taskId);
        $this->assertNotEquals($initialState, $task->isDone(), 'L\'état de la tâche n\'a pas été mis à jour correctement.');
    }

    /**
     * Teste la suppression d'une tâche pour un utilisateur authentifié.
     *
     * Test de type : Unitaire
     *
     * Explication du test :
     * Cette méthode simule la connexion d'un utilisateur authentifié, 
     * envoie une requête de suppression d'une tâche, 
     * puis vérifie que la tâche a été supprimée de la base de données.
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

    /**
     * Teste la tentative de suppression d'une tâche par un utilisateur non autorisé.
     *
     * Test de type : Unitaire
     *
     * Explication du test :
     * Cette méthode simule la connexion d'un utilisateur non autorisé, 
     * essaie de supprimer une tâche, 
     * puis vérifie que la tâche existe toujours dans la base de données.
     */
    public function testDeleteTaskAsUnauthorizedUser(): void
    {
        $entityManager = $this->client->getContainer()->get('doctrine')->getManager();

        $otherUser = $entityManager->getRepository(User::class)->findOneBy(['username' => 'autreUtilisateur']);
        if (!$otherUser) {
            $otherUser = new User();
            $otherUser->setUsername('autreUtilisateur');
            $otherUser->setEmail('autre@example.com');
            $otherUser->setPassword('password');

            $entityManager->persist($otherUser);
            $entityManager->flush();
        }

        $this->client->loginUser($otherUser);
        $this->client->request('POST', '/tasks/' . $this->taskId . '/delete');
        $this->assertResponseRedirects('/tasks');

        $task = $entityManager->getRepository(Task::class)->find($this->taskId);
        $this->assertNotNull($task, 'La tâche n\'aurait pas dû être supprimée.');
    }

    /**
     * Teste la création d'un utilisateur anonyme.
     *
     * Test de type : Unitaire
     *
     * Explication du test :
     * Cette méthode vérifie si un utilisateur anonyme existe, 
     * le supprime si c'est le cas, 
     * puis appelle la méthode pour créer un nouvel utilisateur anonyme 
     * et vérifie que cet utilisateur a été créé correctement.
     */
    public function testGetAnonymousUserCreatesIfNotExists(): void
    {
        $entityManager = $this->client->getContainer()->get('doctrine')->getManager();
        $anonymousUser = $entityManager->getRepository(User::class)->findOneBy(['username' => 'Anonyme']);
        if ($anonymousUser) {
            $entityManager->remove($anonymousUser);
            $entityManager->flush();
        }

        $anonymousUser = $this->client->getContainer()->get('App\Controller\TaskController')->getAnonymousUser($entityManager);

        $this->assertNotNull($anonymousUser, 'L\'utilisateur anonyme devrait avoir été créé.');
        $this->assertEquals('Anonyme', $anonymousUser->getUsername(), 'Le nom d\'utilisateur de l\'utilisateur anonyme ne correspond pas.');
    }
}
