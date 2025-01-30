<?php

namespace App\Services;

use DateTimeImmutable;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;

class TaskFileService
{

    private Filesystem $filesystem;
    private string $taskPath;

    public function __construct(){
        $this->filesystem = new Filesystem();
        $this->taskPath = 'public/tasks/';
    }
    public function createTask(string $title, string $description){
        
        $id = uniqid();
        $filePath = $this->taskPath . $id . '.txt';

        $content = "Titre : " . $title . "\n";
        $content .= "Description : " . $description . "\n";
        $content .= "Date de création : " . new DateTimeImmutable() . "\n";

        try {
            $this->filesystem->dumpFile($filePath, $content);
        } catch (IOExceptionInterface $exception) {
            throw new \RuntimeException("Erreur lors de la création du fichier : " . $exception->getMessage());
        }

        return $id;
    }

    public function updateTask(string $id, string $title, string $description){
        
        $filePath = $this->taskPath . $id . '.txt';
        
        if ($this->filesystem->exists('../public/tasks/{$id}.txt')) {
            echo "Le fichier existe.";
        }

        $content = "Titre : " . $title . "\n";
        $content .= "Description : " . $description . "\n";

        try {
            $this->filesystem->dumpFile($filePath, $content);
        } catch (IOExceptionInterface $exception) {
            throw new \RuntimeException("Erreur lors de la mise à jour du fichier : " . $exception->getMessage());
        }
    }

    public function listTasks(): array
    {
        if (!$this->filesystem->exists($this->taskPath)) {
            return [];
        }
    
        $files = scandir($this->taskPath);
        $tasks = [];
    
        foreach ($files as $file) {
            if (pathinfo($file, PATHINFO_EXTENSION) === 'txt') {
                $filePath = $this->taskPath . $file;
                $content = file_get_contents($filePath);
                
                $id = pathinfo($file, PATHINFO_FILENAME);
                
                preg_match('/^Titre\s*:\s*(.+)$/m', $content, $matches);
                $title = $matches[1] ?? 'Titre inconnu';
    
                $tasks[] = [
                    'id' => $id,
                    'title' => $title,
                ];
            }
        }
    
        return $tasks;
    }
    
    public function getTask(string $id): array
{
    $filePath = $this->taskPath . $id . '.txt';

    if (!$this->filesystem->exists($filePath)) {
        throw new \RuntimeException("La tâche avec l'ID $id n'existe pas.");
    }

    $content = file_get_contents($filePath);

    preg_match('/^Titre\s*:\s*(.+)$/m', $content, $titleMatch);
    preg_match('/^Description\s*:\s*(.+)$/m', $content, $descriptionMatch);
    preg_match('/^Date de création\s*:\s*(.+)$/m', $content, $dateMatch);

    return [
        'id' => $id,
        'title' => $titleMatch[1] ?? 'Titre inconnu',
        'description' => $descriptionMatch[1] ?? 'Description inconnue',
        'created_at' => $dateMatch[1] ?? 'Date inconnue',
    ];
}

public function deleteTask(string $id): void
{
    $filePath = $this->taskPath . $id . '.txt';

    if (!$this->filesystem->exists($filePath)) {
        throw new \RuntimeException("La tâche avec l'ID $id n'existe pas.");
    }

    try {
        $this->filesystem->remove($filePath);
    } catch (IOExceptionInterface $exception) {
        throw new \RuntimeException("Erreur lors de la suppression de la tâche : " . $exception->getMessage());
    }
}

}