<?php

namespace App\Tests\Entity;

use App\Entity\User;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Teste la classe User.
 *
 * Cette classe contient des tests pour s'assurer que la classe User fonctionne correctement. 
 * Elle vérifie que les méthodes de la classe User pour gérer les propriétés de l'utilisateur 
 * (email, nom d'utilisateur, mot de passe, rôles) se comportent comme prévu.
 */
class UserTest extends TestCase
{
    private ValidatorInterface $validator;

    /**
     * Configure le validateur avant chaque test.
     *
     * Cette méthode est exécutée avant chaque méthode de test. Elle initialise 
     * le validateur qui sera utilisé dans les tests.
     */
    protected function setUp(): void
    {
        $this->validator = Validation::createValidator();
    }

    /**
     * Teste la méthode setEmail et getEmail.
     *
     * Cette méthode crée un nouvel utilisateur, définit un email, puis vérifie 
     * que la méthode getEmail retourne l'email correctement.
     */
    public function testSetAndGetEmail(): void
    {
        $user = new User();
        $user->setEmail('test@example.com');

        $this->assertEquals('test@example.com', $user->getEmail());
    }

    /**
     * Teste la méthode setUsername et getUsername.
     *
     * Cette méthode crée un nouvel utilisateur, définit un nom d'utilisateur, 
     * puis vérifie que la méthode getUsername retourne le nom d'utilisateur correctement.
     */
    public function testSetAndGetUsername(): void
    {
        $user = new User();
        $user->setUsername('username123');

        $this->assertEquals('username123', $user->getUsername());
    }

    /**
     * Teste la méthode setPassword et getPassword.
     *
     * Cette méthode crée un nouvel utilisateur, définit un mot de passe, 
     * puis vérifie que la méthode getPassword retourne le mot de passe correctement.
     */
    public function testSetAndGetPassword(): void
    {
        $user = new User();
        $user->setPassword('securePassword');

        $this->assertEquals('securePassword', $user->getPassword());
    }

    /**
     * Teste la méthode setRoles et getRoles.
     *
     * Cette méthode crée un nouvel utilisateur, définit un rôle, puis vérifie 
     * que la méthode getRoles retourne les rôles correctement.
     */
    public function testSetAndGetRoles(): void
    {
        $user = new User();
        $user->setRoles(['ROLE_ADMIN']);

        $this->assertEquals(['ROLE_ADMIN'], $user->getRoles());
    }

    /**
     * Teste le comportement par défaut des rôles.
     *
     * Cette méthode crée un nouvel utilisateur et vérifie que les rôles par défaut 
     * sont 'ROLE_USER'.
     */
    public function testGetRolesDefault(): void
    {
        $user = new User();
        $this->assertEquals(['ROLE_USER'], $user->getRoles());
    }

    /**
     * Teste l'imposition du rôle utilisateur.
     *
     * Cette méthode crée un nouvel utilisateur, définit un rôle, puis vérifie que 
     * même si on essaie de supprimer les rôles, le rôle 'ROLE_USER' est toujours présent.
     */
    public function testSetRolesEnforceUserRole(): void
    {
        $user = new User();
        $user->setRoles(['ROLE_USER']);

        $this->assertEquals(['ROLE_USER'], $user->getRoles());

        $user->setRoles([]); // Aucun rôle
        $this->assertEquals(['ROLE_USER'], $user->getRoles()); // Doit retourner ROLE_USER
    }

    /**
     * Teste que seul le rôle admin est retenu.
     *
     * Cette méthode crée un nouvel utilisateur, définit plusieurs rôles, puis vérifie 
     * que seul 'ROLE_ADMIN' est retourné.
     */
    public function testSetRolesOnlyAdmin(): void
    {
        $user = new User();
        $user->setRoles(['ROLE_ADMIN', 'ROLE_USER']);

        $this->assertEquals(['ROLE_ADMIN'], $user->getRoles()); // Doit seulement retourner ROLE_ADMIN
    }

    /**
     * Teste la méthode getUserIdentifier.
     *
     * Cette méthode crée un nouvel utilisateur, définit un email, puis vérifie 
     * que la méthode getUserIdentifier retourne l'email correctement.
     */
    public function testGetUserIdentifier(): void
    {
        $user = new User();
        $user->setEmail('test@example.com');

        $this->assertEquals('test@example.com', $user->getUserIdentifier());
    }

    /**
     * Teste la méthode eraseCredentials.
     *
     * Cette méthode crée un nouvel utilisateur, définit un mot de passe en clair, 
     * puis vérifie que le mot de passe est effacé après l'appel à eraseCredentials.
     */
    public function testEraseCredentials(): void
    {
        $user = new User();
        $user->setPlainPassword('plaintextpassword');

        $this->assertEquals('plaintextpassword', $user->getPlainPassword());

        $user->eraseCredentials();

        // Vérifie que le mot de passe est nul après l'effacement
        $this->assertNull($user->getPlainPassword()); // Devrait être nul après effacement
    }
}
