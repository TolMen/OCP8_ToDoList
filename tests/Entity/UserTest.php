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

    public function testGetId(): void
    {
        $user = new User();
        // Simulez l'assignation d'un identifiant, si nécessaire
        $reflection = new \ReflectionClass($user);
        $idProperty = $reflection->getProperty('id');
        $idProperty->setAccessible(true);
        $idProperty->setValue($user, 1); // Simulez un ID

        $this->assertEquals(1, $user->getId());
    }


    /**
     * Teste la méthode setEmail() et getEmail() de la classe User.
     *
     * Test de type : Unitaire 
     *
     * Cette méthode crée une instance de User, définit 
     * une adresse email et vérifie que l'email est 
     * correctement enregistré et retourné.
     */
    public function testSetAndGetEmail(): void
    {
        $user = (new User())->setEmail('test@example.com');
        $this->assertEquals('test@example.com', $user->getEmail());
    }

    /**
     * Teste la méthode setUsername() et getUsername() de la classe User.
     *
     * Test de type : Unitaire 
     *
     * Cette méthode crée une instance de User, définit 
     * un nom d'utilisateur et vérifie que le nom d'utilisateur 
     * est correctement enregistré et retourné.
     */
    public function testSetAndGetUsername(): void
    {
        $user = (new User())->setUsername('username123');
        $this->assertEquals('username123', $user->getUsername());
    }

    /**
     * Teste la méthode setPassword() et getPassword() de la classe User.
     *
     * Test de type : Unitaire 
     *
     * Cette méthode crée une instance de User, définit 
     * un mot de passe et vérifie que le mot de passe est 
     * correctement enregistré et retourné.
     */
    public function testSetAndGetPassword(): void
    {
        $user = (new User())->setPassword('securePassword');
        $this->assertEquals('securePassword', $user->getPassword());
    }

    /**
     * Teste la méthode setRoles() et getRoles() de la classe User.
     *
     * Test de type : Unitaire 
     *
     * Cette méthode crée une instance de User, définit 
     * des rôles et vérifie que les rôles sont correctement 
     * enregistrés et retournés.
     */
    public function testSetAndGetRoles(): void
    {
        $user = (new User())->setRoles(['ROLE_ADMIN']);
        $this->assertEquals(['ROLE_ADMIN'], $user->getRoles());
    }

    /**
     * Teste la méthode getRoles() pour le rôle par défaut de l'utilisateur.
     *
     * Test de type : Unitaire 
     *
     * Cette méthode crée une instance de User sans rôles 
     * définis et vérifie que le rôle par défaut est 
     * 'ROLE_USER'.
     */
    public function testGetRolesDefault(): void
    {
        $user = new User();
        $this->assertEquals(['ROLE_USER'], $user->getRoles());
    }

    /**
     * Teste la méthode setRoles() pour s'assurer que le rôle d'utilisateur est appliqué.
     *
     * Test de type : Unitaire 
     *
     * Cette méthode définit des rôles et s'assure que 
     * le rôle 'ROLE_USER' est toujours présent dans la liste 
     * des rôles de l'utilisateur.
     */
    public function testSetRolesEnforceUserRole(): void
    {
        $user = (new User())->setRoles(['ROLE_USER']);
        $this->assertEquals(['ROLE_USER'], $user->getRoles());

        $user->setRoles([]);
        $this->assertEquals(['ROLE_USER'], $user->getRoles());
    }

    /**
     * Teste la méthode setRoles() pour limiter les rôles à 'ROLE_ADMIN'.
     *
     * Test de type : Unitaire 
     *
     * Cette méthode crée une instance de User avec des rôles 
     * multiples et vérifie que seul 'ROLE_ADMIN' est enregistré.
     */
    public function testSetRolesOnlyAdmin(): void
    {
        $user = (new User())->setRoles(['ROLE_ADMIN', 'ROLE_USER']);
        $this->assertEquals(['ROLE_ADMIN'], $user->getRoles());
    }

    /**
     * Teste la méthode getUserIdentifier() de la classe User.
     *
     * Test de type : Unitaire 
     *
     * Cette méthode crée une instance de User, définit 
     * une adresse email et vérifie que l'identifiant utilisateur 
     * est correctement retourné.
     */
    public function testGetUserIdentifier(): void
    {
        $user = (new User())->setEmail('test@example.com');
        $this->assertEquals('test@example.com', $user->getUserIdentifier());
    }

    /**
     * Teste la méthode eraseCredentials() de la classe User.
     *
     * Test de type : Unitaire 
     *
     * Cette méthode crée une instance de User, définit un mot 
     * de passe en clair, puis appelle eraseCredentials() 
     * pour s'assurer que le mot de passe en clair est nul 
     * après l'appel.
     */
    public function testEraseCredentials(): void
    {
        $user = (new User())->setPlainPassword('plaintextpassword');
        $this->assertEquals('plaintextpassword', $user->getPlainPassword());

        $user->eraseCredentials();
        $this->assertNull($user->getPlainPassword());
    }
}
