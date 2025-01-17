<?php

namespace App\Controller;

use App\Entity\Task;
use App\Form\TaskType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class TaskController extends AbstractController
{

    #[Route('/task/index', name: 'task_index')]
    public function listTasks(){}

    #[Route(path: '/task/create', name: 'task_create')]
    public function createTask()
    {
        $task = new Task();

        $form = $this->createForm(TaskType::class, $task);

        return $this->render('task/create.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/task/edit', name: 'task_edit')]
    public function editTask(){}

    #[Route('/task/view', name: 'task_view')]
    public function viewTask(){}

    #[Route('/task/delete', name: 'task_delete')]
    public function deleteTask(){}
}
