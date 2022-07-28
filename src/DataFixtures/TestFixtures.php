<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\Task;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;

use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class TestFixtures extends Fixture implements FixtureGroupInterface
{
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public static function getGroups(): array
    {
        return ['group-test'];
    }

    public function load(ObjectManager $em)
    {
        $user = new User();
        $user->setUsername('test-login');
        $user->setEmail('test@login.fr');
        $user->setPassword($this->passwordEncoder->encodePassword($user, 'azerty'));
        $user->setRoles(['ROLE_USER']);

        $em->persist($user);
        $em->flush();

        $user = new User();
        $user->setUsername('tasks-test-user');
        $user->setEmail('task@user.fr');
        $user->setPassword($this->passwordEncoder->encodePassword($user, 'azerty'));
        $user->setRoles(['ROLE_USER']);

        $em->persist($user);
        $em->flush();

        $user2 = new User();
        $user2->setUsername('tasks-test-admin');
        $user2->setEmail('task@admin.fr');
        $user2->setPassword($this->passwordEncoder->encodePassword($user, 'azerty'));
        $user2->setRoles(['ROLE_ADMIN']);

        $em->persist($user2);
        $em->flush();

        $user3 = new User();
        $user3->setUsername('anonymous');
        $user3->setEmail('task@anonymous.fr');
        $user3->setPassword($this->passwordEncoder->encodePassword($user, 'azerty'));
        $user3->setRoles(['ROLE_USER']);

        $em->persist($user3);
        $em->flush();

        $task = new Task();
        $task->setTitle('task test 1');
        $task->setContent('La description de la task test 1');
        $task->setUser($user);
        $task->setIsDone(false);

        $em->persist($task);
        $em->flush();

        $task = new Task();
        $task->setTitle('task to delete');
        $task->setContent('Task a supprimé appertenant à task-test-user');
        $task->setUser($user);
        $task->setIsDone(false);

        $em->persist($task);
        $em->flush();

        $task = new Task();
        $task->setTitle('task to del');
        $task->setContent('Task a supprimé appertenant à task-test-user');
        $task->setUser($user);
        $task->setIsDone(false);

        $em->persist($task);
        $em->flush();

        $task = new Task();
        $task->setTitle('task test 2');
        $task->setContent('La description de la task test 2');
        $task->setUser($user2);
        $task->setIsDone(false);

        $em->persist($task);
        $em->flush();

        $task = new Task();
        $task->setTitle('task to delete 2');
        $task->setContent('Task a supprimé appertenant a task test admin');
        $task->setUser($user2);
        $task->setIsDone(false);

        $em->persist($task);
        $em->flush();

        $task = new Task();
        $task->setTitle('task to delete 3');
        $task->setContent('Task a supprimé appertenant a anonymous');
        $task->setUser($user2);
        $task->setIsDone(false);

        $em->persist($task);
        $em->flush();

        $user = new User();
        $user->setUsername('users-test-user');
        $user->setEmail('test@user.fr');
        $user->setPassword($this->passwordEncoder->encodePassword($user, 'azerty'));
        $user->setRoles(['ROLE_USER']);

        $em->persist($user);
        $em->flush();

        $user = new User();
        $user->setUsername('users-test-admin');
        $user->setEmail('test@admin.fr');
        $user->setPassword($this->passwordEncoder->encodePassword($user, 'azerty'));
        $user->setRoles(['ROLE_ADMIN']);

        $em->persist($user);
        $em->flush();

        $user = new User();
        $user->setUsername('entitytask-user');
        $user->setEmail('entity@user.fr');
        $user->setPassword($this->passwordEncoder->encodePassword($user, 'azerty'));
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
        $user->setPassword($this->passwordEncoder->encodePassword($user, 'azerty'));
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
}
