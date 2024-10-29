<?php

namespace App\Controller;

use App\Entity\Task;
use App\Entity\User;
use App\Form\TaskType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

class TaskController extends AbstractController
{
    #[Route('/tasks', name: 'task_list', methods: ['GET'])]
    public function list(EntityManagerInterface $em): Response
    {
        // Récupérer les tâches triées par date de création (createdAt) de la plus récente à la plus ancienne
        $tasks = $em->getRepository(Task::class)->findBy([], ['createdAt' => 'DESC']);

        return $this->render('task/list.html.twig', [
            'tasks' => $tasks,
        ]);
    }

    #[Route('/tasks/create', name: 'task_create', methods: ['GET', 'POST'])]
    public function create(Request $request, EntityManagerInterface $em): Response
    {
        $task = new Task();
        $form = $this->createForm(TaskType::class, $task);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Récupérer l'utilisateur actuel ou assigner "Anonyme"
            $user = $this->getUser() ?? $this->getAnonymousUser($em);
            $task->setAuthor($user);

            // Définir la date de création
            $task->setCreatedAt(new \DateTime());

            // Persister la tâche
            $em->persist($task);
            $em->flush();

            return $this->redirectToRoute('task_list');
        }

        return $this->render('task/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    private function getAnonymousUser(EntityManagerInterface $em): User
    {
        $anonymousUser = $em->getRepository(User::class)->findOneBy(['username' => 'Anonyme']);

        // Créer l'utilisateur "Anonyme" s'il n'existe pas
        if (!$anonymousUser) {
            $anonymousUser = (new User())
                ->setUsername('Anonyme')
                ->setEmail('anonyme@example.com')
                ->setPassword('');

            $em->persist($anonymousUser);
            $em->flush();
        }

        return $anonymousUser;
    }

    #[Route('/tasks/{id}/edit', name: 'task_edit', methods: ['GET', 'POST'])]
    public function edit(Task $task, Request $request, EntityManagerInterface $em): Response
    {
        $form = $this->createForm(TaskType::class, $task);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();

            return $this->redirectToRoute('task_list');
        }

        return $this->render('task/edit.html.twig', [
            'form' => $form->createView(),
            'task' => $task,
        ]);
    }

    #[Route('/tasks/{id}/toggle', name: 'task_toggle', methods: ['POST'])]
    public function toggleTask(Task $task, EntityManagerInterface $em): Response
    {
        $task->toggle(!$task->isDone());
        $em->flush();

        return $this->redirectToRoute('task_list');
    }

    #[Route('/tasks/{id}/delete', name: 'task_delete', methods: ['POST'])]
    public function deleteTask(Task $task, EntityManagerInterface $em): Response
    {
        // Vérifiez que l'utilisateur connecté est l'auteur de la tâche ou a un rôle ADMIN
        if ($task->getAuthor() === $this->getUser() || $this->isGranted('ROLE_ADMIN')) {
            $em->remove($task);
            $em->flush();
        }

        return $this->redirectToRoute('task_list');
    }
}
