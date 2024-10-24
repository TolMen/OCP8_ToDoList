<?php

// tests/Entity/TaskTest.php
namespace App\Tests\Entity;

use App\Entity\Task;
use App\Entity\User;
use PHPUnit\Framework\TestCase;

class TaskTest extends TestCase
{
    public function testCanSetAndGetAuthor()
    {
        $task = new Task();
        $user = new User();
        $user->setUsername('TestUser');

        $task->setAuthor($user);

        $this->assertSame($user, $task->getAuthor());
    }

    public function testCanToggleIsDone()
    {
        $task = new Task();
        $this->assertFalse($task->isDone());

        $task->toggle(true);
        $this->assertTrue($task->isDone());

        $task->toggle(false);
        $this->assertFalse($task->isDone());
    }

    public function testCanSetAndGetTitle()
    {
        $task = new Task();
        $task->setTitle('Test Title');

        $this->assertEquals('Test Title', $task->getTitle());
    }

    public function testCanSetAndGetContent()
    {
        $task = new Task();
        $task->setContent('Test Content');

        $this->assertEquals('Test Content', $task->getContent());
    }

    public function testCanSetAndGetCreatedAt()
    {
        $task = new Task();
        $date = new \DateTime('2024-01-01');
        $task->setCreatedAt($date);

        $this->assertEquals($date, $task->getCreatedAt());
    }

    public function testIdIsNullInitially()
    {
        $task = new Task();
        $this->assertNull($task->getId());
    }

    public function testConstructorInitializesProperties()
    {
        $task = new Task();

        $this->assertInstanceOf(\DateTime::class, $task->getCreatedAt());
        $this->assertFalse($task->isDone());
    }
}
