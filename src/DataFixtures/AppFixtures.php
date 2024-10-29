<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\Task;
use App\Entity\Tag;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        // Création des utilisateurs
        $users = [];

        // 1. Utilisateur Anonyme
        $anonymousUser = new User();
        $anonymousUser->setEmail('anonyme@todolist.com');
        $anonymousUser->setUsername('Anonyme');
        $anonymousUser->setRoles([]); // Pas de rôle
        $anonymousUser->setPassword(''); // Pas de mot de passe
        $manager->persist($anonymousUser);
        $users[] = $anonymousUser;

        // 2. Utilisateur Admin
        $adminUser = new User();
        $adminUser->setEmail('admin@todolist.com');
        $adminUser->setUsername('AdminUser');
        $adminUser->setRoles(['ROLE_ADMIN']);
        $adminUser->setPassword($this->passwordHasher->hashPassword($adminUser, 'securePassword'));
        $manager->persist($adminUser);
        $users[] = $adminUser;

        // 3 à 10. Autres utilisateurs réalistes
        $names = [
            ['John Doe', 'john.doe@todolist.com'],
            ['Jane Smith', 'jane.smith@todolist.com'],
            ['Alice Johnson', 'alice.johnson@todolist.com'],
            ['Bob Brown', 'bob.brown@todolist.com'],
            ['Charlie Davis', 'charlie.davis@todolist.com'],
            ['Diana Evans', 'diana.evans@todolist.com'],
            ['Eva Green', 'eva.green@todolist.com'],
            ['Frank Harris', 'frank.harris@todolist.com']
        ];

        foreach ($names as $name) {
            $user = new User();
            $user->setEmail($name[1]);
            $user->setUsername($name[0]);
            $user->setRoles(['ROLE_USER']);
            $user->setPassword($this->passwordHasher->hashPassword($user, 'userPassword'));
            $manager->persist($user);
            $users[] = $user;
        }

        // Création des tags
        $tags = [
            'Urgent',
            'Important',
            'En attente',
            'Développement',
            'Révision',
            'Recherche',
            'Formation',
            'Documentation',
            'Maintenance',
            'Suivi'
        ];

        $tagEntities = [];
        foreach ($tags as $tagName) {
            $tag = new Tag();
            $tag->setName($tagName);
            $manager->persist($tag);
            $tagEntities[] = $tag;
        }

        // Création des tâches
        $tasksData = [
            ['Créer une maquette de l\'application', 'Créer une maquette pour l\'application de gestion de tâches.', false, [$tagEntities[0], $tagEntities[3]], $anonymousUser],
            ['Rédiger la documentation utilisateur', 'Documenter les fonctionnalités de l\'application.', false, [$tagEntities[1], $tagEntities[8]], $anonymousUser],
            ['Corriger les bugs signalés', 'Réparer les bugs identifiés par les utilisateurs.', true, [$tagEntities[0], $tagEntities[5]], $adminUser],
            ['Mettre à jour le système de gestion', 'Mettre à jour la base de données avec les nouvelles fonctionnalités.', true, [$tagEntities[1], $tagEntities[9]], $users[2]],
            ['Planifier la prochaine réunion', 'Organiser une réunion pour discuter des progrès.', false, [$tagEntities[2]], $users[3]],
            ['Suivre l\'évolution des tâches', 'Vérifier l\'état d\'avancement des tâches.', false, [$tagEntities[2], $tagEntities[4]], $users[4]],
            ['Effectuer une formation sur l\'outil', 'Former l\'équipe sur le nouvel outil de gestion.', false, [$tagEntities[6]], $users[5]],
            ['Préparer une présentation', 'Préparer une présentation pour le comité de direction.', true, [$tagEntities[1]], $users[6]],
            ['Faire une recherche sur les nouvelles technologies', 'Explorer les nouvelles technologies pour les intégrer dans l\'application.', false, [$tagEntities[7]], $users[7]],
            ['Mettre à jour les dépendances du projet', 'S\'assurer que toutes les dépendances du projet sont à jour.', false, [$tagEntities[9]], $users[0]],
            ['Réviser le code de l\'application', 'Revoir le code pour s\'assurer qu\'il respecte les normes.', true, [$tagEntities[4]], $users[1]]
        ];

        foreach ($tasksData as $taskData) {
            $task = new Task();
            $task->setTitle($taskData[0]);
            $task->setContent($taskData[1]);

            // Générer une date aléatoire entre le 1er janvier 2020 et aujourd'hui
            $start = strtotime('2020-01-01');
            $end = strtotime('now');
            $randomTimestamp = random_int($start, $end);
            $task->setCreatedAt(new \DateTime("@$randomTimestamp")); // Créer un DateTime à partir du timestamp

            $task->toggle($taskData[2]);
            $task->setAuthor($taskData[4]);

            foreach ($taskData[3] as $tag) {
                $task->addTag($tag);
            }

            $manager->persist($task);
        }

        $manager->flush();
    }
}
