<?php

namespace Tests\AppBundle\Entity;


use AppBundle\Entity\Task;
use AppBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class TaskTest extends WebTestCase
{
    public function testload()
    {

        static::bootKernel();
        $em = static::$kernel->getContainer()->get('doctrine.orm.entity_manager');

        $user = new User();
        $user->setUsername('entitytask-user');
        $user->setEmail('entity@user.fr');
        $plainPassword = 'azerty';
        $encoder = static::$kernel->getContainer()->get('security.password_encoder');
        $encoded = $encoder->encodePassword($user, $plainPassword);
        $user->setPassword($encoded);
        $user->setRoles(['ROLE_ADMIN']);

        $em->persist($user);
        $em->flush();

        $task = new Task();
        $task->setTitle('entity task');
        $task->setContent('La description de la task');
        $task->setUser($user);
        $task->setIsDone(false);
        $date = "01-09-2015";
        $task->setCreatedAt(\DateTime::createFromFormat('d-m-Y', $date));

        $em->persist($task);
        $em->flush();
    }



    public function testGet()
    {
        static::bootKernel();
        $em = static::$kernel->getContainer()->get('doctrine.orm.entity_manager');
        $task = $em->getRepository('AppBundle:Task')->findOneBy(array('title' => "entity task"));
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
