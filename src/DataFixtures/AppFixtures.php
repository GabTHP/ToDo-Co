<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\Task;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;

use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture implements FixtureGroupInterface
{
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public static function getGroups(): array
    {
        return ['group-demo'];
    }

    public function load(ObjectManager $em)
    {
        $user = new User();
        $user->setUsername('gab');
        $user->setEmail('gab@hotmail.fr');
        $plainPassword = 'azerty';
        $user->setPassword($this->passwordEncoder->encodePassword($user, 'azerty'));
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
        $user->setUsername('simple-user');
        $user->setEmail('user@hotmail.fr');
        $plainPassword = 'azerty';
        $user->setPassword($this->passwordEncoder->encodePassword($user, 'azerty'));
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

        $task = new Task();
        $task->setTitle('exemple6');
        $task->setContent('On ne sait pas qui a créé cette tâche');
        $task->setIsDone(false);
        $em->persist($task);
        $em->flush();

        $em->persist($task);
        $em->flush();
        $task = new Task();
        $task->setTitle('exemple7');
        $task->setContent('On ne sait pas non plus qui a créé cette tâche');
        $task->setIsDone(false);
        $em->persist($task);
        $em->flush();
    }
}
