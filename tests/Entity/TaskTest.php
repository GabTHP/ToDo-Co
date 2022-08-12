<?php

namespace App\Tests\Entity;


use App\Entity\Task;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class TaskTest extends WebTestCase
{

    public function testGet()
    {
        static::bootKernel();
        $em = static::$kernel->getContainer()->get('doctrine.orm.entity_manager');
        $task = $em->getRepository(Task::class)->findOneBy(array('title' => "entity task"));
        static::assertEquals("entity task", $task->getTitle());
        static::assertEquals("La description de la task", $task->getContent());
        static::assertEquals(false, $task->getIsDone());
        $date = \DateTime::createFromFormat('d-m-Y', "01-09-2015");
        $date = $date->setTime(0, 0, 0);
        $task_date = $task->getCreatedAt();
        $task_date = $task_date->setTime(0, 0, 0);
        static::assertEquals($date, $task_date);
        static::assertEquals("entitytask-user", $task->getUser()->getUsername());
    }
}
