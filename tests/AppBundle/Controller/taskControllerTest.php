<?php

namespace Tests\AppBundle\Controller;

use AppBundle\Entity\Task;
use AppBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class TaskControllerTest extends WebTestCase
{
    public function testloadUsers()
    {

        static::bootKernel();
        $em = static::$kernel->getContainer()->get('doctrine.orm.entity_manager');

        $user = new User();
        $user->setUsername('tasks-test-user');
        $user->setEmail('task@user.fr');
        $plainPassword = 'azerty';
        $encoder = static::$kernel->getContainer()->get('security.password_encoder');
        $encoded = $encoder->encodePassword($user, $plainPassword);
        $user->setPassword($encoded);
        $user->setRoles(['ROLE_USER']);

        $em->persist($user);
        $em->flush();

        $user2 = new User();
        $user2->setUsername('tasks-test-admin');
        $user2->setEmail('task@admin.fr');
        $plainPassword = 'azerty';
        $encoder = static::$kernel->getContainer()->get('security.password_encoder');
        $encoded = $encoder->encodePassword($user, $plainPassword);
        $user2->setPassword($encoded);
        $user2->setRoles(['ROLE_ADMIN']);

        $em->persist($user2);
        $em->flush();

        $user3 = new User();
        $user3->setUsername('anonymous');
        $user3->setEmail('task@anonymous.fr');
        $plainPassword = 'azerty';
        $encoder = static::$kernel->getContainer()->get('security.password_encoder');
        $encoded = $encoder->encodePassword($user, $plainPassword);
        $user3->setPassword($encoded);
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
    }

    #non connected user tests
    public function testIndexTasks()
    {
        $client = static::createClient();

        $client->request('GET', '/tasks');

        $this->assertEquals(302, $client->getResponse()->getStatusCode());
    }


    #connected user 
    public function testListActionAdmin()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/login');

        $form = $crawler->selectButton('Se connecter')->form();
        $form['_username'] = 'tasks-test-user';
        $form['_password'] = 'azerty';
        $client->submit($form);

        $crawler = $client->followRedirect();
        $crawler = $client->request('GET', '/tasks');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testCreateAction()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/login');

        $form = $crawler->selectButton('Se connecter')->form();
        $form['_username'] = 'tasks-test-user';
        $form['_password'] = 'azerty';
        $client->submit($form);

        $crawler = $client->followRedirect();
        $crawler = $client->request('GET', '/tasks/create');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $form = $crawler->selectButton('Ajouter')->form();
        $form['task[title]'] = 'task-created';
        $form['task[content]'] = 'description de la task';
        $client->submit($form);
        $crawler = $client->followRedirect();
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        static::assertEquals("Superbe !", $crawler->filter('div.alert.alert-success strong')->text());
    }

    public function testEditAction()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/login');

        $form = $crawler->selectButton('Se connecter')->form();
        $form['_username'] = 'tasks-test-user';
        $form['_password'] = 'azerty';
        $client->submit($form);

        $crawler = $client->followRedirect();

        $em = static::$kernel->getContainer()->get('doctrine.orm.entity_manager');
        $task = $em->getRepository('AppBundle:Task')->findOneBy(array('title' => "task test 1"));
        $task_id = $task->getId();

        $crawler = $client->request('GET', "/tasks/$task_id/edit");
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $form = $crawler->selectButton('Modifier')->form();
        $form['task[title]'] = 'task test 1';
        $form['task[content]'] = 'la tâche a été modifiée';
        $client->submit($form);
        $crawler = $client->followRedirect();
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        static::assertEquals("Superbe !", $crawler->filter('div.alert.alert-success strong')->text());
    }

    public function testDeleteAction()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/login');

        $form = $crawler->selectButton('Se connecter')->form();
        $form['_username'] = 'tasks-test-user';
        $form['_password'] = 'azerty';
        $client->submit($form);

        #test delete task by the owner of the task

        $em = static::$kernel->getContainer()->get('doctrine.orm.entity_manager');
        $task = $em->getRepository('AppBundle:Task')->findOneBy(array('title' => "task to delete"));
        $task_id = $task->getId();
        $crawler = $client->followRedirect();
        $crawler = $client->request('GET', "/tasks/$task_id/delete");
        $crawler = $client->followRedirect();
        $this->assertEquals(200, $client->getResponse()->getStatusCode());

        #test delete task by not the owner of the task

        $em = static::$kernel->getContainer()->get('doctrine.orm.entity_manager');
        $task = $em->getRepository('AppBundle:Task')->findOneBy(array('title' => "task to delete 2"));
        $task_id = $task->getId();
        $crawler = $client->request('GET', "/tasks/$task_id/delete");
        $this->assertEquals(403, $client->getResponse()->getStatusCode());

        #test delete task by owner anonymous
        $em = static::$kernel->getContainer()->get('doctrine.orm.entity_manager');
        $task = $em->getRepository('AppBundle:Task')->findOneBy(array('title' => "task to delete 3"));
        $task_id = $task->getId();
        $crawler = $client->request('GET', "/tasks/$task_id/delete");
        $this->assertEquals(403, $client->getResponse()->getStatusCode());
    }

    public function testToggleAction()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/login');

        $form = $crawler->selectButton('Se connecter')->form();
        $form['_username'] = 'tasks-test-user';
        $form['_password'] = 'azerty';
        $client->submit($form);

        $em = static::$kernel->getContainer()->get('doctrine.orm.entity_manager');
        $task = $em->getRepository('AppBundle:Task')->findOneBy(array('title' => "task test 1"));
        $task_id = $task->getId();

        $crawler = $client->followRedirect();
        $crawler = $client->request('GET', "/tasks/$task_id/toggle");
        $this->assertEquals(302, $client->getResponse()->getStatusCode());
        $crawler = $client->followRedirect();
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        static::assertEquals("Superbe !", $crawler->filter('div.alert.alert-success strong')->text());
    }





    #connected user as "ROLE_ADMIN"

    public function testDeleteActionByAdmin()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/login');

        $form = $crawler->selectButton('Se connecter')->form();
        $form['_username'] = 'tasks-test-admin';
        $form['_password'] = 'azerty';
        $client->submit($form);

        #test delete task by the admin from different owner

        $em = static::$kernel->getContainer()->get('doctrine.orm.entity_manager');
        $task = $em->getRepository('AppBundle:Task')->findOneBy(array('title' => "task to del"));
        $task_id = $task->getId();
        $crawler = $client->followRedirect();
        $crawler = $client->request('GET', "/tasks/$task_id/delete");
        $this->assertEquals(403, $client->getResponse()->getStatusCode());

        #test delete task by the owner of the task which is admin

        $em = static::$kernel->getContainer()->get('doctrine.orm.entity_manager');
        $task = $em->getRepository('AppBundle:Task')->findOneBy(array('title' => "task to delete 2"));
        $task_id = $task->getId();
        $crawler = $client->request('GET', "/tasks/$task_id/delete");
        $crawler = $client->followRedirect();
        $this->assertEquals(200, $client->getResponse()->getStatusCode());

        #test delete task by owner anonymou swith admin account 
        $em = static::$kernel->getContainer()->get('doctrine.orm.entity_manager');
        $task = $em->getRepository('AppBundle:Task')->findOneBy(array('title' => "task to delete 3"));
        $task_id = $task->getId();
        $crawler = $client->request('GET', "/tasks/$task_id/delete");
        $crawler = $client->followRedirect();
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }
}
