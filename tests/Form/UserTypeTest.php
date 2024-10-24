<?php

// tests/Form/UserTypeTest.php
namespace App\Tests\Form;

use App\Entity\User;
use App\Form\UserType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Test\TypeTestCase;

class UserTypeTest extends TypeTestCase
{
    public function testSubmitValidData()
    {
        // Créer un objet User avec des données valides
        $user = new User();
        $user->setUsername('testuser');
        $user->setEmail('testuser@example.com');
        $user->setPlainPassword('password123');

        $formData = [
            'username' => 'testuser',
            'plainPassword' => [
                'first' => 'password123',
                'second' => 'password123',
            ],
            'email' => 'testuser@example.com',
            'roles' => ['ROLE_ADMIN'],
        ];

        // Créer le formulaire avec les données de test
        $form = $this->factory->create(UserType::class, $user, ['is_creation' => true]);

        // Soumettre le formulaire avec les données
        $form->submit($formData);

        // Vérifier que le formulaire est valide
        $this->assertTrue($form->isSubmitted());
        $this->assertTrue($form->isValid());

        // Vérifier que l'objet User a bien été modifié
        $this->assertEquals('testuser', $user->getUsername());
        $this->assertEquals('testuser@example.com', $user->getEmail());
        $this->assertEquals('password123', $user->getPlainPassword());
        $this->assertEquals(['ROLE_ADMIN'], $user->getRoles());
    }

    public function testBuildForm()
    {
        $form = $this->factory->create(UserType::class, null, ['is_creation' => true]);

        // Vérifier que les bons champs sont présents dans le formulaire
        $this->assertTrue($form->has('username'));
        $this->assertTrue($form->has('plainPassword'));
        $this->assertTrue($form->has('email'));
        $this->assertTrue($form->has('roles'));

        // Vérifier le type des champs
        $this->assertInstanceOf(TextType::class, $form->get('username')->getConfig()->getType()->getInnerType());
        $this->assertInstanceOf(RepeatedType::class, $form->get('plainPassword')->getConfig()->getType()->getInnerType());
        $this->assertInstanceOf(EmailType::class, $form->get('email')->getConfig()->getType()->getInnerType());
        $this->assertInstanceOf(ChoiceType::class, $form->get('roles')->getConfig()->getType()->getInnerType());
    }
}
