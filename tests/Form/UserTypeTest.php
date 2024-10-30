<?php

namespace App\Tests\Form;

use App\Entity\User;
use App\Form\UserType;
use Symfony\Component\Form\Test\TypeTestCase;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserTypeTest extends TypeTestCase
{
    /**
     * Teste la construction du formulaire avec l'option de création.
     *
     * Test de type : Unitaire 
     *
     * Cette méthode crée un utilisateur et soumet un 
     * formulaire avec des données valides. Elle vérifie 
     * que le formulaire est valide et que les données 
     * de l'utilisateur sont correctement définies après 
     * la soumission.
     */
    public function testBuildFormWithCreationOption(): void
    {
        $formData = [
            'username' => 'TestUser',
            'plainPassword' => [
                'first' => 'password123',
                'second' => 'password123',
            ],
            'email' => 'testuser@example.com',
            'roles' => ['ROLE_ADMIN'],
        ];

        $user = new User();

        $form = $this->factory->create(UserType::class, $user, ['is_creation' => true]);

        $form->submit($formData);

        $this->assertTrue($form->isSubmitted() && $form->isValid());
        $this->assertEquals('TestUser', $user->getUsername());
        $this->assertEquals('testuser@example.com', $user->getEmail());
        $this->assertEquals(['ROLE_ADMIN'], $user->getRoles());
        $this->assertEquals('password123', $form->get('plainPassword')->get('first')->getData());
    }

    /**
     * Teste un formulaire invalide avec des mots de passe non appariés.
     *
     * Test de type : Unitaire 
     *
     * Cette méthode soumet un formulaire avec des mots 
     * de passe qui ne correspondent pas et vérifie que 
     * le formulaire est soumis mais n'est pas valide.
     */
    public function testInvalidFormWithMismatchedPasswords(): void
    {
        $formData = [
            'username' => 'TestUser',
            'plainPassword' => [
                'first' => 'password123',
                'second' => 'password456',
            ],
            'email' => 'testuser@example.com',
        ];

        $user = new User();

        $form = $this->factory->create(UserType::class, $user, ['is_creation' => true]);

        $form->submit($formData);

        $this->assertTrue($form->isSubmitted());
        $this->assertFalse($form->isValid());
    }

    /**
     * Teste la configuration des options du formulaire UserType.
     *
     * Test de type : Unitaire 
     *
     * Cette méthode vérifie que les options sont 
     * correctement configurées pour le formulaire UserType, 
     * notamment la classe de données et l'option 
     * 'is_creation'.
     */
    public function testConfigureOptions(): void
    {
        $resolver = new OptionsResolver();
        $formType = new UserType();
        $formType->configureOptions($resolver);

        $options = $resolver->resolve();

        $this->assertEquals(User::class, $options['data_class']);
        $this->assertArrayHasKey('is_creation', $options);
        $this->assertFalse($options['is_creation']);
    }
}
