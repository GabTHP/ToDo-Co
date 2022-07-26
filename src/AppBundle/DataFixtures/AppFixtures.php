<?php

namespace AppBundle\DataFixtures;

use AppBundle\Entity\User;
use AppBundle\Entity\Task;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;

use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $em)
    {
        $user = new User();
        $user->setUsername('gab');
        $user->setEmail('gab@hotmail.fr');
        $plainPassword = 'azerty';
        $user->setPassword($this->encoder->encodePassword($user, $plainPassword));
        $user->setRoles(['ROLE_ADMIN']);
        $em->persist($user);
        $em->flush();

        $task = new Task();
        $task->setTitle('exemple1');
        $task->setContent('La description de la task 1 créé par gab qui est ADMIN');
        $task->setUser($user);
        $task->setIsDone(false);
        $em->persist($task);
        $em->flush();

        $task = new Task();
        $task->setTitle('exemple2');
        $task->setContent('La description de la task 2 créé par gab qui est ADMIN');
        $task->setUser($user);
        $task->setIsDone(false);
        $em->persist($task);
        $em->flush();

        $task = new Task();
        $task->setTitle('exemple3');
        $task->setContent('La description de la task 3 créé par gab qui est ADMIN');
        $task->setUser($user);
        $task->setIsDone(false);
        $em->persist($task);
        $em->flush();

        $user = new User();
        $user->setUsername('le user');
        $user->setEmail('user@hotmail.fr');
        $plainPassword = 'azerty';
        $user->setPassword($this->encoder->encodePassword($user, $plainPassword));
        $user->setRoles(['ROLE_USER']);
        $em->persist($user);
        $em->flush();

        $task = new Task();
        $task->setTitle('exemple4');
        $task->setContent('La description de la task 4 créé par un simple user');
        $task->setUser($user);
        $task->setIsDone(false);
        $em->persist($task);
        $em->flush();

        $task = new Task();
        $task->setTitle('exemple5');
        $task->setContent('La description de la task 5 créé par un simple user');
        $task->setUser($user);
        $task->setIsDone(false);
        $em->persist($task);
        $em->flush();

        $user = new User();
        $user->setUsername('anonymous');
        $user->setEmail('anon@hotmail.fr');
        $plainPassword = 'azerty';
        $user->setPassword($this->encoder->encodePassword($user, $plainPassword));
        $user->setRoles(['ROLE_USER']);
        $em->persist($user);
        $em->flush();

        $task = new Task();
        $task->setTitle('exemple6');
        $task->setContent('On ne sait pas qui a créé cette tâche');
        $task->setUser($user);
        $task->setIsDone(false);
        $em->persist($task);
        $em->flush();

        $em->persist($task);
        $em->flush();
        $task = new Task();
        $task->setTitle('exemple7');
        $task->setContent('On ne sait pas non plus qui a créé cette tâche');
        $task->setUser($user);
        $task->setIsDone(false);
        $em->persist($task);
        $em->flush();
    }
}
