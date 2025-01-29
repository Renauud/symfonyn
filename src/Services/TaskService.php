<?php
 
namespace App\Services;

use DateTimeImmutable;

class TaskService
{
    public function canEdit(DateTimeImmutable $createdAt): bool{
    
        $diff = (new DateTimeImmutable())->diff($createdAt);
    
        return $diff->days <= 3;
    }
}