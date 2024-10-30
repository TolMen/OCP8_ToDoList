<?php

namespace App\Tests\Entity;

use App\Entity\User;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Validator\Validation;

class UserTest extends TestCase
{
    private $validator;

    protected function setUp(): void
    {
        $this->validator = Validation::createValidator();
    }

    public function testSetAndGetEmail(): void
    {
        $user = (new User())->setEmail('test@example.com');
        $this->assertEquals('test@example.com', $user->getEmail());
    }

    public function testSetAndGetUsername(): void
    {
        $user = (new User())->setUsername('username123');
        $this->assertEquals('username123', $user->getUsername());
    }

    public function testSetAndGetPassword(): void
    {
        $user = (new User())->setPassword('securePassword');
        $this->assertEquals('securePassword', $user->getPassword());
    }

    public function testSetAndGetRoles(): void
    {
        $user = (new User())->setRoles(['ROLE_ADMIN']);
        $this->assertEquals(['ROLE_ADMIN'], $user->getRoles());
    }

    public function testGetRolesDefault(): void
    {
        $user = new User();
        $this->assertEquals(['ROLE_USER'], $user->getRoles());
    }

    public function testSetRolesEnforceUserRole(): void
    {
        $user = (new User())->setRoles(['ROLE_USER']);
        $this->assertEquals(['ROLE_USER'], $user->getRoles());

        $user->setRoles([]);
        $this->assertEquals(['ROLE_USER'], $user->getRoles());
    }

    public function testSetRolesOnlyAdmin(): void
    {
        $user = (new User())->setRoles(['ROLE_ADMIN', 'ROLE_USER']);
        $this->assertEquals(['ROLE_ADMIN'], $user->getRoles());
    }

    public function testGetUserIdentifier(): void
    {
        $user = (new User())->setEmail('test@example.com');
        $this->assertEquals('test@example.com', $user->getUserIdentifier());
    }

    public function testEraseCredentials(): void
    {
        $user = (new User())->setPlainPassword('plaintextpassword');
        $this->assertEquals('plaintextpassword', $user->getPlainPassword());

        $user->eraseCredentials();
        $this->assertNull($user->getPlainPassword());
    }
}
