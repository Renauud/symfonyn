<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class TaskController extends AbstractController
{

    #[Route('/task/index', name: 'task_index')]
    public function listTasks(){}

    #[Route('/task/create', name: 'task_create')]
    public function createTask(){}

    #[Route('/task/edit', name: 'task_edit')]
    public function editTask(){}

    #[Route('/task/view', name: 'task_view')]
    public function viewTask(){}

    #[Route('/task/delete', name: 'task_delete')]
    public function deleteTask(){}
}
