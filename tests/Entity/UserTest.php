<?php

namespace App\Tests\Entity;

use App\Entity\User;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class UserTest extends TestCase
{
    private ValidatorInterface $validator;

    protected function setUp(): void
    {
        $this->validator = Validation::createValidator();
    }

    public function testSetAndGetEmail(): void
    {
        $user = new User();
        $user->setEmail('test@example.com');

        $this->assertEquals('test@example.com', $user->getEmail());
    }

    public function testSetAndGetUsername(): void
    {
        $user = new User();
        $user->setUsername('username123');

        $this->assertEquals('username123', $user->getUsername());
    }

    public function testSetAndGetPassword(): void
    {
        $user = new User();
        $user->setPassword('securePassword');

        $this->assertEquals('securePassword', $user->getPassword());
    }

    public function testSetAndGetRoles(): void
    {
        $user = new User();
        $user->setRoles(['ROLE_ADMIN']);

        $this->assertEquals(['ROLE_ADMIN'], $user->getRoles());
    }

    public function testGetRolesDefault(): void
    {
        $user = new User();
        $this->assertEquals(['ROLE_USER'], $user->getRoles());
    }

    public function testSetRolesEnforceUserRole(): void
    {
        $user = new User();
        $user->setRoles(['ROLE_USER']);

        $this->assertEquals(['ROLE_USER'], $user->getRoles());

        $user->setRoles([]); // Aucun rôle
        $this->assertEquals(['ROLE_USER'], $user->getRoles()); // Doit retourner ROLE_USER
    }

    public function testSetRolesOnlyAdmin(): void
    {
        $user = new User();
        $user->setRoles(['ROLE_ADMIN', 'ROLE_USER']);

        $this->assertEquals(['ROLE_ADMIN'], $user->getRoles()); // Doit seulement retourner ROLE_ADMIN
    }

    public function testGetUserIdentifier(): void
    {
        $user = new User();
        $user->setEmail('test@example.com');

        $this->assertEquals('test@example.com', $user->getUserIdentifier());
    }

    public function testEraseCredentials(): void
    {
        $user = new User();
        $user->setPlainPassword('plaintextpassword');

        $this->assertEquals('plaintextpassword', $user->getPlainPassword());

        $user->eraseCredentials();

        $this->assertNull($user->getPlainPassword()); // Devrait être nul après effacement
    }
}
