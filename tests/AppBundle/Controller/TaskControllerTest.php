<?php

namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class TaskControllerTest extends WebTestCase
{

    public function testIndexTasks()
    {
        $client = static::createClient();

        $client->request('GET', '/tasks');

        $this->assertEquals(302, $client->getResponse()->getStatusCode());
    }
}
