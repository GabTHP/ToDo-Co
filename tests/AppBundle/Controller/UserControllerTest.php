<?php

namespace Tests\AppBundle\Controller;

use Doctrine\ORM\Tools\SchemaTool;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UserControllerTest extends WebTestCase
{


    #non connected user tests
    public function testIndexUsers()
    {
        $client = static::createClient();

        $client->request('GET', '/users');

        $this->assertEquals(302, $client->getResponse()->getStatusCode());
    }

    public function testCreateUsers()
    {
        $client = static::createClient();

        $client->request('GET', '/users/create');

        $this->assertEquals(302, $client->getResponse()->getStatusCode());
    }
    public function testEditUsers()
    {
        $client = static::createClient();

        $client->request('GET', '/users/1/edit');

        $this->assertEquals(302, $client->getResponse()->getStatusCode());
    }
}
