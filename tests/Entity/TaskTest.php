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

    public function testSet()
    {

        static::bootKernel();
        $em = static::$kernel->getContainer()->get('doctrine.orm.entity_manager');

        $user = new User();
        $user->setUsername('user-to-link');
        $user->setEmail('entity@user-to-link.fr');
        $plainPassword = 'azerty';
        $encoder = static::$kernel->getContainer()->get('security.password_encoder');
        $encoded = $encoder->encodePassword($user, $plainPassword);
        $user->setPassword($encoded);
        $user->setRoles(['ROLE_ADMIN']);

        $em->persist($user);
        $em->flush();

        $task = new Task();
        $task->setTitle('entity-task-to-create');
        $task->setContent('La description de la task');
        $task->setUser($user);
        $task->setIsDone(false);
        $date = "01-09-2015";
        $task->setCreatedAt(\DateTime::createFromFormat('d-m-Y', $date));

        $em->persist($task);
        $em->flush();
        $task = $em->getRepository(Task::class)->findOneBy(array('title' => "entity-task-to-create"));
        static::assertEquals("entity-task-to-create", $task->getTitle());
    }
}
