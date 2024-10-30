<?php

namespace App\Tests\DataFixtures;

use App\DataFixtures\AppFixtures;
use App\Entity\User;
use App\Entity\Task;
use App\Entity\Tag;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AppFixturesTest extends WebTestCase
{
    private EntityManagerInterface $entityManager;

    protected function setUp(): void
    {
        $client = static::createClient();
        $this->entityManager = $client->getContainer()->get('doctrine')->getManager();

        // Vider la base de données
        $this->entityManager->getConnection()->executeQuery('SET FOREIGN_KEY_CHECKS=0;');
        $this->entityManager->getConnection()->executeQuery('TRUNCATE TABLE task_tag;');
        $this->entityManager->getConnection()->executeQuery('TRUNCATE TABLE task;');
        $this->entityManager->getConnection()->executeQuery('TRUNCATE TABLE tag;');
        $this->entityManager->getConnection()->executeQuery('TRUNCATE TABLE user;');
        $this->entityManager->getConnection()->executeQuery('SET FOREIGN_KEY_CHECKS=1;');
    }

    /*
     * Charge les fixtures pour l'application.
     *
     * Test de type : Unitaire 
     *
     * Cette méthode vérifie que les données de test sont chargées correctement
     * dans la base de données, y compris les utilisateurs, les tags et les tâches.
     * Elle s'assure également que les rôles sont attribués correctement aux utilisateurs.
     */
    public function testLoadFixtures(): void
    {
        $fixture = new AppFixtures(static::getContainer()->get('security.password_hasher'));
        $fixture->load($this->entityManager);

        $userRepository = $this->entityManager->getRepository(User::class);
        $this->assertCount(10, $userRepository->findAll(), 'Should have 10 users');

        $tagRepository = $this->entityManager->getRepository(Tag::class);
        $this->assertCount(10, $tagRepository->findAll(), 'Should have 10 tags');

        $taskRepository = $this->entityManager->getRepository(Task::class);
        $this->assertCount(11, $taskRepository->findAll(), 'Should have 11 tasks');

        $adminUser = $userRepository->findOneBy(['email' => 'admin@todolist.com']);
        $this->assertNotNull($adminUser);
        $this->assertContains('ROLE_ADMIN', $adminUser->getRoles());

        $anonymousUser = $userRepository->findOneBy(['email' => 'anonyme@todolist.com']);
        $this->assertNotNull($anonymousUser);

        $roles = $anonymousUser->getRoles();
        $this->assertContains('ROLE_USER', $roles, 'Anonymous user should have ROLE_USER');
    }

    /*
     * Nettoie les ressources après l'exécution des tests.
     *
     * Test de type : Unitaire 
     *
     * Cette méthode est appelée après chaque test pour s'assurer que
     * les ressources sont libérées correctement et que la base de données
     * est réinitialisée si nécessaire.
     */
    protected function tearDown(): void
    {
        parent::tearDown();
        $this->entityManager->close();
    }
}
