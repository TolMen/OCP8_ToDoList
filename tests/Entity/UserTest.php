<?php

// tests/Entity/UserTest.php
namespace App\Tests\Entity;

use App\Entity\User;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    public function testSetRolesWithAdminRole()
    {
        $user = new User();
        $user->setRoles(['ROLE_ADMIN']);

        $this->assertContains('ROLE_ADMIN', $user->getRoles());
        $this->assertCount(1, $user->getRoles()); // Vérifiez qu'il n'y a qu'un seul rôle
    }

    public function testSetRolesWithEmptyArray()
    {
        $user = new User();
        $user->setRoles([]);

        $this->assertContains('ROLE_USER', $user->getRoles());
        $this->assertCount(1, $user->getRoles()); // Vérifiez qu'il y a un rôle par défaut
    }

    public function testSetRolesWithoutAdminRole()
    {
        $user = new User();
        $user->setRoles(['ROLE_USER', 'ROLE_EDITOR']); // Autre rôle sans ROLE_ADMIN

        $this->assertContains('ROLE_USER', $user->getRoles());
        $this->assertCount(1, $user->getRoles()); // Vérifiez qu'il y a uniquement ROLE_USER
    }

    public function testDefaultRoleIsUser()
    {
        $user = new User();
        $this->assertContains('ROLE_USER', $user->getRoles());
    }

    // Ajoutez ici les autres tests que vous avez déjà écrits
    public function testCanSetAndGetUsername()
    {
        $user = new User();
        $user->setUsername('TestUser');

        $this->assertEquals('TestUser', $user->getUsername());
    }

    public function testCanSetAndGetEmail()
    {
        $user = new User();
        $user->setEmail('test@example.com');

        $this->assertEquals('test@example.com', $user->getEmail());
    }

    public function testCanSetAndGetPassword()
    {
        $user = new User();
        $user->setPassword('securepassword');

        $this->assertEquals('securepassword', $user->getPassword());
    }

    public function testCanSetAndGetPlainPassword()
    {
        $user = new User();
        $user->setPlainPassword('plainpassword');

        $this->assertEquals('plainpassword', $user->getPlainPassword());
    }

    public function testGetUserIdentifier()
    {
        $user = new User();
        $user->setEmail('test@example.com');

        $this->assertEquals('test@example.com', $user->getUserIdentifier());
    }

    public function testCanGetId()
    {
        $user = new User();
        $this->assertNull($user->getId());
    }

    public function testEraseCredentials()
    {
        $user = new User();
        $user->setPlainPassword('plainpassword');
        $this->assertEquals('plainpassword', $user->getPlainPassword());

        $user->eraseCredentials();
        $this->assertNull($user->getPlainPassword());
    }
}
