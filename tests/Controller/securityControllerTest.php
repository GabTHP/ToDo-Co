<?php

namespace App\Tests\Controller;

use App\Entity\User;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class SecurityControllerTest extends WebTestCase
{



    public function testLoginPageUser()
    {
        $client = static::createClient();

        $client->request('GET', '/login');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }
    public function testLoginActionSuccess()
    {
        static::bootKernel();
        $client = static::createClient();

        $crawler = $client->request('GET', '/login');

        $form = $crawler->selectButton('Se connecter')->form();
        $form['_username'] = 'test-login';
        $form['_password'] = 'azerty';
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
