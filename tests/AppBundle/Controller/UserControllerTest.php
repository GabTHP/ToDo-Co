<?php

namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UserControllerTest extends WebTestCase
{

    public function testIndexUsers()
    {
        $client = static::createClient();

        $client->request('GET', '/users');

        $this->assertEquals(302, $client->getResponse()->getStatusCode());
    }
}
