<?php

namespace Tests\AppBundle\Controller;

use AppBundle\Entity\User;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class SecurityControllerTest extends WebTestCase
{




    public function testLoginPageUser()
    {
        static::bootKernel();
        $em = static::$kernel->getContainer()->get('doctrine.orm.entity_manager');
        $user = new User();
        $user->setUsername('gab');
        $user->setEmail('anonymous@example.org');
        $plainPassword = 'a';
        $encoder = static::$kernel->getContainer()->get('security.password_encoder');
        $encoded = $encoder->encodePassword($user, $plainPassword);
        $user->setPassword($encoded);
        $user->setRoles(['ROLE_USER']);

        $em->persist($user);
        $em->flush();

        $client = static::createClient();

        $client->request('GET', '/login');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }
    public function testLoginActionSuccess()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/login');

        $form = $crawler->selectButton('Se connecter')->form();
        $form['_username'] = 'gab';
        $form['_password'] = 'a';
        $client->submit($form);

        $crawler = $client->followRedirect();
        static::assertSame(200, $client->getResponse()->getStatusCode());
        static::assertSame("Bienvenue sur Todo List, l'application vous permettant de gérer l'ensemble de vos tâches sans effort !", $crawler->filter('h1')->text());
    }

    public function testLoginActionFail()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/login');

        $form = $crawler->selectButton('Se connecter')->form();
        $form['_username'] = 'fail';
        $form['_password'] = 'fail';
        $client->submit($form);

        $crawler = $client->followRedirect();
        static::assertSame(200, $client->getResponse()->getStatusCode());
        static::assertSame("Invalid credentials.", $crawler->filter('div.alert.alert-danger')->text());
    }
}
