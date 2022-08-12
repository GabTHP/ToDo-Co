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
}
