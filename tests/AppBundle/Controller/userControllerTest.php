<?php

namespace Tests\AppBundle\Controller;

use AppBundle\Entity\User;
use Doctrine\ORM\Tools\SchemaTool;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UserControllerTest extends WebTestCase
{
    public function testloadUsers()
    {

        static::bootKernel();
        $em = static::$kernel->getContainer()->get('doctrine.orm.entity_manager');

        $user = new User();
        $user->setUsername('users-test-user');
        $user->setEmail('test@user.fr');
        $plainPassword = 'azerty';
        $encoder = static::$kernel->getContainer()->get('security.password_encoder');
        $encoded = $encoder->encodePassword($user, $plainPassword);
        $user->setPassword($encoded);
        $user->setRoles(['ROLE_USER']);

        $em->persist($user);
        $em->flush();

        $user = new User();
        $user->setUsername('users-test-admin');
        $user->setEmail('test@admin.fr');
        $plainPassword = 'azerty';
        $encoder = static::$kernel->getContainer()->get('security.password_encoder');
        $encoded = $encoder->encodePassword($user, $plainPassword);
        $user->setPassword($encoded);
        $user->setRoles(['ROLE_ADMIN']);

        $em->persist($user);
        $em->flush();
    }


    #non connected user tests
    public function testListAction()
    {
        $client = static::createClient();

        $client->request('GET', '/users');

        $this->assertEquals(302, $client->getResponse()->getStatusCode());
    }

    public function testCreateAction()
    {
        $client = static::createClient();

        $client->request('GET', '/users/create');

        $this->assertEquals(302, $client->getResponse()->getStatusCode());
    }
    public function testEditAction()
    {
        $client = static::createClient();

        $client->request('GET', '/users/1/edit');

        $this->assertEquals(302, $client->getResponse()->getStatusCode());
    }

    #connected user as "ROLE_USER"
    public function testCreateActionUser()
    {


        $client = static::createClient();

        $crawler = $client->request('GET', '/login');

        $form = $crawler->selectButton('Se connecter')->form();
        $form['_username'] = 'users-test-user';
        $form['_password'] = 'azerty';
        $client->submit($form);

        $crawler = $client->followRedirect();
        $crawler = $client->request('GET', '/users/create');
        $this->assertEquals(403, $client->getResponse()->getStatusCode());
    }

    public function testEditActionUser()
    {
        #connected user as "ROLE_USER"
        static::bootKernel();
        $em = static::$kernel->getContainer()->get('doctrine.orm.entity_manager');

        $client = static::createClient();

        $crawler = $client->request('GET', '/login');

        $form = $crawler->selectButton('Se connecter')->form();
        $form['_username'] = 'users-test-user';
        $form['_password'] = 'azerty';
        $client->submit($form);

        $crawler = $client->followRedirect();
        $crawler = $client->request('GET', '/users/1/edit');
        $this->assertEquals(403, $client->getResponse()->getStatusCode());
    }
    #connected user as "ROLE_ADMIN"
    public function testListActionAdmin()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/login');

        $form = $crawler->selectButton('Se connecter')->form();
        $form['_username'] = 'users-test-admin';
        $form['_password'] = 'azerty';
        $client->submit($form);

        $crawler = $client->followRedirect();
        $crawler = $client->request('GET', '/users');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testCreateActionAdmin()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/login');

        $form = $crawler->selectButton('Se connecter')->form();
        $form['_username'] = 'users-test-admin';
        $form['_password'] = 'azerty';
        $client->submit($form);

        $crawler = $client->followRedirect();
        $crawler = $client->request('GET', '/users/create');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $form = $crawler->selectButton('Ajouter')->form();
        $form['user[username]'] = 'user-created';
        $form['user[password][first]'] = 'azerty';
        $form['user[password][second]'] = 'azerty';
        $form['user[email]'] = 'user@created.fr';
        $form['user[roles]'] = "ROLE_USER";
        $client->submit($form);
        $crawler = $client->followRedirect();
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        static::assertEquals("Superbe !", $crawler->filter('div.alert.alert-success strong')->text());
    }

    public function testeditActionAdmin()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/login');

        $form = $crawler->selectButton('Se connecter')->form();
        $form['_username'] = 'users-test-admin';
        $form['_password'] = 'azerty';
        $client->submit($form);

        $crawler = $client->followRedirect();
        $crawler = $client->request('GET', '/users/2/edit');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $form = $crawler->selectButton('Modifier')->form();
        $form['user[username]'] = 'user-edited';
        $form['user[password][first]'] = 'azerty';
        $form['user[password][second]'] = 'azerty';
        $form['user[email]'] = 'user@edited.fr';
        $form['user[roles]'] = "ROLE_USER";
        $client->submit($form);
        $crawler = $client->followRedirect();
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        static::assertEquals("Superbe !", $crawler->filter('div.alert.alert-success strong')->text());
    }
}
