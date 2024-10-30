<?php

namespace App\Tests\Form;

use App\Entity\User;
use App\Form\UserType;
use Symfony\Component\Form\Test\TypeTestCase;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserTypeTest extends TypeTestCase
{
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

        // Vérifie que le formulaire est valide
        $this->assertTrue($form->isSubmitted() && $form->isValid());

        // Vérifie les données après soumission
        $this->assertEquals('TestUser', $user->getUsername());
        $this->assertEquals('testuser@example.com', $user->getEmail());
        $this->assertEquals(['ROLE_ADMIN'], $user->getRoles());

        // Vérifie le mot de passe directement via la première valeur du champ répétée
        $this->assertEquals('password123', $form->get('plainPassword')->get('first')->getData());
    }

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

        // Vérifie que le formulaire est soumis mais non valide à cause du mot de passe différent
        $this->assertTrue($form->isSubmitted());
        $this->assertFalse($form->isValid());
    }

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
