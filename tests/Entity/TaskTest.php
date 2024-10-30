<?php

namespace App\Tests\Entity;

use App\Entity\Task;
use App\Entity\User;
use PHPUnit\Framework\TestCase;

class TaskTest extends TestCase
{
    public function testSetAuthorAndGetAuthor(): void
    {
        $task = new Task();
        $user = (new User())->setUsername('TestUser');
        $task->setAuthor($user);

        $this->assertSame($user, $task->getAuthor());
    }

    public function testSetAuthorAsAnonymous(): void
    {
        $task = new Task();
        $anonymousUser = (new User())->setUsername('Anonyme');
        $task->setAuthor($anonymousUser);

        $this->assertEquals('Anonyme', $task->getAuthor()->getUsername());
    }

    public function testToggleIsDone(): void
    {
        $task = new Task();

        $this->assertFalse($task->isDone());

        $task->toggle(true);
        $this->assertTrue($task->isDone());

        $task->toggle(false);
        $this->assertFalse($task->isDone());
    }
}
