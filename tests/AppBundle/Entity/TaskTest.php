<?php

namespace Tests\AppBundle\Entity;


use AppBundle\Entity\Task;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class TaskTest extends WebTestCase
{

    public function testGetId()
    {
        $task = new Task();
        static::assertEquals(null, $task->getId());
    }
    public function testGetTitle()
    {
        $task = new Task();
        $task->setTitle("title");
        static::assertEquals("title", $task->getTitle());
    }

    public function testGetIsDone()
    {
        $task = new Task();
        static::assertEquals($task->getIsDone(), null);
    }
    public function testGetContent()
    {
        $task = new Task();
        static::assertEquals($task->getContent(), null);
    }
}
