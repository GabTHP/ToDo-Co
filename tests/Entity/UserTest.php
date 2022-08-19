<?php

namespace App\Tests\Entity;


use App\Entity\Task;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UserTest extends WebTestCase
{


    public function testGet()
    {
        static::bootKernel();
        $em = static::$kernel->getContainer()->get('doctrine.orm.entity_manager');
        $user = $em->getRepository(User::class)->findOneBy(array('username' => "entityuser"));
        static::assertEquals("entity task", $user->getTasks()[0]->getTitle());
        $user->removeTask($user->getTasks()[0]);
        static::assertEquals(null, $user->getTasks()[0]);
    }

    public function testSet()
    {

        static::bootKernel();
        $em = static::$kernel->getContainer()->get('doctrine.orm.entity_manager');

        $task = new Task();
        $task->setTitle('entity-task-to-link-with-user');
        $task->setContent('La description de la task');
        $task->setIsDone(false);
        $date = "01-09-2015";
        $task->setCreatedAt(\DateTime::createFromFormat('d-m-Y', $date));
        $em->persist($task);
        $em->flush();

        $user = new User();
        $user->setUsername('entity-user-to-add');
        $user->setEmail('entityuser@user-to-add.fr');
        $plainPassword = 'azerty';
        $encoder = static::$kernel->getContainer()->get('security.password_encoder');
        $encoded = $encoder->encodePassword($user, $plainPassword);
        $user->setPassword($encoded);
        $user->setRoles(['ROLE_ADMIN']);
        $user->addTask($task);
        $em->persist($user);
        $em->flush();
        $user = $em->getRepository(User::class)->findOneBy(array('username' => "entity-user-to-add"));
        static::assertEquals("entity-user-to-add", $user->getUsername());
    }
}
