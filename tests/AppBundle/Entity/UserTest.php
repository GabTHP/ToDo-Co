<?php

namespace Tests\AppBundle\Entity;


use AppBundle\Entity\Task;
use AppBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UserTest extends WebTestCase
{
    public function testload()
    {

        static::bootKernel();
        $em = static::$kernel->getContainer()->get('doctrine.orm.entity_manager');

        $task = new Task();
        $task->setTitle('entity task');
        $task->setContent('La description de la task');
        $task->setIsDone(false);
        $date = "01-09-2015";
        $task->setCreatedAt(\DateTime::createFromFormat('d-m-Y', $date));

        $em->persist($task);
        $em->flush();

        $user = new User();
        $user->setUsername('entityuser');
        $user->setEmail('entityuser@user.fr');
        $plainPassword = 'azerty';
        $encoder = static::$kernel->getContainer()->get('security.password_encoder');
        $encoded = $encoder->encodePassword($user, $plainPassword);
        $user->setPassword($encoded);
        $user->setRoles(['ROLE_ADMIN']);
        $user->addTask($task);

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
        $user = $em->getRepository('AppBundle:User')->findOneBy(array('username' => "entityuser"));
        static::assertEquals("entity task", $user->getTasks()[0]->getTitle());
        $user->removeTask($user->getTasks()[0]);
    }
}
