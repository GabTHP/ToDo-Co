<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class HomeControllerTest extends WebTestCase
{
    public function testIndex(): void
    {

        $client = self::createClient();

        // Request a specific page
        $client->request('get', '/');

        // Validate a successful response and some content

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }
}
