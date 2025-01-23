<?php

namespace App\Controller;

use App\Entity\Task;
use App\Form\TaskType;
use App\Repository\TaskRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class TaskController extends AbstractController
{

    #[Route('/task/index', name: 'task_index')]
    public function listTasks(TaskRepository $taskRepository){

        $tasks = $taskRepository->listAllTasks();

        return $this->render('task/index.html.twig', [
            'tasks' => $tasks,
        ]);
    }

    #[Route(path: '/task/create', name: 'task_create')]
    public function createTask(Request $request, EntityManagerInterface $em): Response
    {
        $task = new Task();
        $form = $this->createForm(TaskType::class, $task);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $task->getName();
            $task->getDescription();
            $task->setAuthor('AuteurTemp'); // temporaire : remplacer par l'user qd on pourra se connecter

            $em->persist($task);
            $em->flush();

            $this->addFlash('success', 'Tâche créée avec succès !');

            return $this->redirectToRoute('/task/index');
        }

        return $this->render('task/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/task/edit', name: 'task_edit')]
    public function editTask(){
        return $this->render('task/edit.html.twig');

    }

    #[Route('/task/view', name: 'task_view')]
    public function viewTask(){
        return $this->render('task/view.html.twig');

    }

    #[Route('/task/delete', name: 'task_delete')]
    public function deleteTask(){}
}
