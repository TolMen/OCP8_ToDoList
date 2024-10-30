<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use App\Entity\Task;

// Classe de test pour le contrôleur des tâches
/**
 * Teste la classe TaskController.
 *
 * Cette classe contient des tests pour s'assurer que les méthodes du contrôleur des tâches 
 * fonctionnent comme prévu. Les tests incluent la création, l'édition, l'affichage, 
 * le basculement et la suppression de tâches par des utilisateurs authentifiés et non authentifiés.
 */
class TaskControllerTest extends WebTestCase
{
    private $client; // Client de test pour simuler les requêtes HTTP
    private $taskId; // ID de la tâche utilisée pour les tests

    // Méthode exécutée avant chaque test pour initialiser l'environnement de test
    protected function setUp(): void
    {
        $this->client = static::createClient(); // Création d'un client de test
        $this->taskId = $this->createTaskForTest(); // Création d'une tâche pour les tests
    }

    // Méthode pour simuler la connexion d'un utilisateur authentifié
    private function loginAsAuthenticatedUser(): void
    {
        $user = [
            'username' => 'testuser', // Remplacez par un nom d'utilisateur valide
            'password' => 'password'    // Remplacez par le mot de passe de l'utilisateur
        ];

        // Envoi d'une requête POST pour se connecter
        $this->client->request('POST', '/login', $user);
    }

    // Méthode pour créer une tâche pour les tests
    private function createTaskForTest(): int
    {
        $entityManager = $this->client->getContainer()->get('doctrine')->getManager();

        // Création d'une nouvelle tâche
        $task = new Task();
        $task->setTitle('Tâche de test'); // Définir le titre de la tâche
        $task->setContent('Contenu de la tâche de test'); // Définir le contenu de la tâche

        // Persistance de la tâche dans la base de données
        $entityManager->persist($task);
        $entityManager->flush();

        // Retourner l'ID de la tâche créée
        return $task->getId();
    }

    /**
     * Teste la création d'une tâche par un utilisateur authentifié.
     *
     * Cette méthode simule la connexion d'un utilisateur, accède à la page de création de tâche, 
     * remplit le formulaire avec des données de test, puis soumet le formulaire. 
     * Elle vérifie enfin que l'utilisateur est redirigé vers la liste des tâches.
     */
    public function testCreateTaskAsAuthenticatedUser(): void
    {
        $this->loginAsAuthenticatedUser(); // Connexion de l'utilisateur
        $crawler = $this->client->request('GET', '/tasks/create'); // Accès à la page de création
        $this->assertResponseIsSuccessful(); // Vérifie que la réponse est réussie

        $form = $crawler->filter('form[name="task"]')->first()->form(); // Récupération du formulaire
        $this->assertNotNull($form, 'Le formulaire de création de tâche n\'a pas été trouvé.'); // Vérifie la présence du formulaire

        // Remplissage du formulaire avec des données de test
        $form['task[title]'] = 'Nouvelle tâche'; // Titre de la nouvelle tâche
        $form['task[content]'] = 'Contenu de la tâche'; // Contenu de la nouvelle tâche
        $this->client->submit($form); // Soumission du formulaire
        $this->assertResponseRedirects('/tasks'); // Vérifie la redirection vers la liste des tâches
    }

    /**
     * Teste l'édition d'une tâche par un utilisateur authentifié.
     *
     * Cette méthode simule la connexion d'un utilisateur, accède à la page d'édition de la tâche
     * et soumet le formulaire d'édition. Elle vérifie ensuite que l'utilisateur est redirigé vers la liste des tâches 
     * et que la tâche a bien été mise à jour dans la base de données.
     */
    public function testEditTaskAsAuthenticatedUser(): void
    {
        $this->loginAsAuthenticatedUser(); // Connexion de l'utilisateur

        // Utilisation de l'ID de la tâche créée dans setUp
        $crawler = $this->client->request('GET', '/tasks/' . $this->taskId . '/edit'); // Accès à la page d'édition

        // Vérifiez que la réponse est réussie
        $this->assertResponseIsSuccessful();

        $form = $crawler->filter('form[name="task"]')->first()->form(); // Récupération du formulaire
        $this->assertNotNull($form, 'Le formulaire d\'édition de tâche n\'a pas été trouvé.'); // Vérifie la présence du formulaire

        // Remplir le formulaire avec de nouvelles valeurs
        $form['task[title]'] = 'Tâche modifiée'; // Nouveau titre de la tâche
        $form['task[content]'] = 'Contenu de la tâche modifiée'; // Nouveau contenu de la tâche
        $this->client->submit($form); // Soumission du formulaire

        // Vérifiez que la redirection se fait vers la page des tâches
        $this->assertResponseRedirects('/tasks');

        // Vérifiez que la tâche a bien été mise à jour dans la base de données
        $entityManager = $this->client->getContainer()->get('doctrine')->getManager();
        $task = $entityManager->getRepository(Task::class)->find($this->taskId); // Récupération de la tâche mise à jour
        $this->assertEquals('Tâche modifiée', $task->getTitle(), 'Le titre de la tâche n\'a pas été mis à jour.'); // Vérification de la mise à jour
    }

    /**
     * Teste l'affichage de la liste des tâches pour un utilisateur authentifié.
     *
     * Cette méthode simule la connexion d'un utilisateur et accède à la liste des tâches. 
     * Elle vérifie que la réponse est réussie et que le titre de la page est correct.
     */
    public function testListTasksAsAuthenticatedUser(): void
    {
        $this->loginAsAuthenticatedUser(); // Connexion de l'utilisateur

        // Simuler la requête pour accéder à la liste des tâches
        $crawler = $this->client->request('GET', '/tasks');

        // Vérifier que la réponse est réussie
        $this->assertResponseIsSuccessful();

        // Vérifiez que le bon titre est présent
        $this->assertSelectorTextContains('h1', 'Liste des tâches'); // Assurez-vous que cela correspond au texte exact dans votre template
    }

    /**
     * Teste la création d'une tâche sans utilisateur authentifié.
     *
     * Cette méthode accède à la page de création de tâche sans être connecté et tente de soumettre le formulaire. 
     * Elle vérifie ensuite que la tâche a bien été créée dans la base de données.
     */
    public function testCreateTaskWithoutAuthenticatedUser(): void
    {
        // Accéder à la page de création de tâche
        $crawler = $this->client->request('GET', '/tasks/create');

        // Vérifiez que la réponse est réussie
        $this->assertResponseIsSuccessful();

        // Vérifiez que le formulaire est présent
        $form = $crawler->filter('form[name="task"]')->first()->form();
        $this->assertNotNull($form, 'Le formulaire de création de tâche n\'a pas été trouvé.'); // Vérifie la présence du formulaire

        // Remplir le formulaire
        $form['task[title]'] = 'Tâche test'; // Titre de la tâche test
        $form['task[content]'] = 'Contenu de la tâche test'; // Contenu de la tâche test

        // Soumettez le formulaire
        $this->client->submit($form);

        // Vérifiez la redirection vers la liste des tâches
        $this->assertResponseRedirects('/tasks');

        // Récupérez l'EntityManager pour vérifier la création de la tâche
        $entityManager = $this->client->getContainer()->get('doctrine')->getManager();
        $task = $entityManager->getRepository(Task::class)->findOneBy(['title' => 'Tâche test']); // Vérification de la création de la tâche

        // Vérifiez que la tâche a été créée avec succès
        $this->assertNotNull($task, 'La tâche n\'a pas été créée.'); // Vérifie que la tâche n'est pas nulle
        $this->assertEquals('Tâche test', $task->getTitle(), 'Le titre de la tâche ne correspond pas.'); // Vérifie que le titre est correct
    }

    /**
     * Teste le basculement de l'état d'une tâche pour un utilisateur authentifié.
     *
     * Cette méthode simule la connexion d'un utilisateur, accède à la méthode de basculement d'une tâche,
     * puis vérifie que l'utilisateur est redirigé vers la liste des tâches 
     * et que l'état de la tâche a bien été modifié dans la base de données.
     */
    public function testToggleTaskAsAuthenticatedUser(): void
    {
        $this->loginAsAuthenticatedUser(); // Connexion de l'utilisateur

        // Accéder à la méthode de basculement de la tâche
        $this->client->request('POST', '/tasks/' . $this->taskId . '/toggle');

        // Vérifier que la redirection se fait vers la liste des tâches
        $this->assertResponseRedirects('/tasks');

        // Vérifier que l'état de la tâche a été changé dans la base de données
        $entityManager = $this->client->getContainer()->get('doctrine')->getManager();
        $task = $entityManager->getRepository(Task::class)->find($this->taskId);
        $this->assertTrue($task->isDone(), 'La tâche devrait être marquée comme faite.'); // Vérifie que la tâche est marquée comme terminée
    }

    /**
     * Teste la suppression d'une tâche pour un utilisateur authentifié.
     *
     * Cette méthode simule la connexion d'un utilisateur, accède à la méthode de suppression d'une tâche,
     * puis vérifie que l'utilisateur est redirigé vers la liste des tâches 
     * et que la tâche a bien été supprimée de la base de données.
     */
    public function testDeleteTaskAsAuthenticatedUser(): void
    {
        $this->loginAsAuthenticatedUser(); // Connexion de l'utilisateur

        // Accéder à la méthode de suppression de la tâche
        $this->client->request('POST', '/tasks/' . $this->taskId . '/delete');

        // Vérifier que la redirection se fait vers la liste des tâches
        $this->assertResponseRedirects('/tasks');

        // Vérifier que la tâche n'existe plus dans la base de données
        $entityManager = $this->client->getContainer()->get('doctrine')->getManager();
        $task = $entityManager->getRepository(Task::class)->find($this->taskId);
        $this->assertNull($task, 'La tâche devrait avoir été supprimée.'); // Vérifie que la tâche est nulle
    }
}
