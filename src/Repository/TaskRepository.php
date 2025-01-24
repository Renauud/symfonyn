<?php

namespace App\Repository;

use App\Entity\Task;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Task>
 */
class TaskRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Task::class);
    }

    public function listAllTasks()
    {
        $query = $this->createQueryBuilder('t')
        ->select('t.id', 't.name', 't.description', 't.createdAt', 't.updatedAt', 't.author')
        ->orderBy('t.createdAt', 'DESC');

        $query = $query->getQuery();

        return $query->getResult();
    }

    public function createTask(string $name, string $description, string $author): Task
    {
        $task = new Task();
        $task->setName($name);
        $task->setDescription($description);
        $task->setAuthor($author);

        return $task;
    }

    public function editTask(int $taskId, string $name, string $description){

        $query = $this->createQueryBuilder('t')
        ->update()
        ->set('t.name', ':name')
        ->set('t.description', ':description')
        ->set('t.updatedAt', ':updatedAt')
        ->where('t.id = :taskId')
        ->setParameter('name', $name)
        ->setParameter('description', $description)
        ->setParameter('updatedAt', new \DateTimeImmutable())
        ->setParameter('taskId', $taskId);

        $query = $query->getQuery();

        return $query->getResult();

    }

    public function viewTask(int $taskId){
        $query = $this->createQueryBuilder('t')
        ->select('t')
        ->where('t.id = :taskId')
        ->setParameter('taskId', $taskId);

        $query = $query->getQuery();

        return $query->getOneOrNullResult();
    }

    public function deleteTask(int $taskId){

        $query = $this->createQueryBuilder('t')
        ->delete()
        ->where('t.id = :taskId')
        ->setParameter('taskId', $taskId);

        $query = $query->getQuery();

        return $query->getResult();
    }


    //    /**
    //     * @return Task[] Returns an array of Task objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('t')
    //            ->andWhere('t.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('t.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Task
    //    {
    //        return $this->createQueryBuilder('t')
    //            ->andWhere('t.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
