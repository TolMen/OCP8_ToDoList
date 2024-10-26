<?php

namespace App\Tests\Form;

use App\Entity\User;
use App\Form\UserType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Test\TypeTestCase;

/**
 * Teste le formulaire UserType.
 *
 * Cette classe contient des tests pour s'assurer que le formulaire UserType fonctionne 
 * correctement. Elle vérifie notamment que les données sont correctement soumises 
 * et que la structure du formulaire est conforme aux attentes.
 */
class UserTypeTest extends TypeTestCase
{
    /**
     * Teste la soumission de données valides au formulaire.
     *
     * Cette méthode crée une instance de User avec des données valides, 
     * soumet ces données via le formulaire, et vérifie que le formulaire est 
     * soumis et valide. Elle s'assure également que les données de l'objet User 
     * sont correctement mises à jour après la soumission du formulaire.
     */
    public function testSubmitValidData()
    {
        // Créer un objet User avec des données valides
        $user = new User();
        $user->setUsername('testuser');
        $user->setEmail('testuser@example.com');
        $user->setPlainPassword('password123');

        // Données à soumettre dans le formulaire
        $formData = [
            'username' => 'testuser',
            'plainPassword' => [
                'first' => 'password123', // Mot de passe répété
                'second' => 'password123', // Confirmation du mot de passe
            ],
            'email' => 'testuser@example.com',
            'roles' => ['ROLE_ADMIN'], // Rôle de l'utilisateur
        ];

        // Créer le formulaire avec les données de test
        $form = $this->factory->create(UserType::class, $user, ['is_creation' => true]);

        // Soumettre le formulaire avec les données
        $form->submit($formData);

        // Vérifier que le formulaire est soumis
        $this->assertTrue($form->isSubmitted());

        // Vérifier que le formulaire est valide
        $this->assertTrue($form->isValid());

        // Vérifier que l'objet User a bien été modifié
        $this->assertEquals('testuser', $user->getUsername());
        $this->assertEquals('testuser@example.com', $user->getEmail());
        $this->assertEquals('password123', $user->getPlainPassword());
        $this->assertEquals(['ROLE_ADMIN'], $user->getRoles());
    }

    /**
     * Teste la construction du formulaire.
     *
     * Cette méthode vérifie que le formulaire UserType est construit 
     * correctement. Elle s'assure que les champs 'username', 'plainPassword', 
     * 'email' et 'roles' sont présents et que les types de ces champs sont corrects.
     */
    public function testBuildForm()
    {
        // Créer le formulaire UserType
        $form = $this->factory->create(UserType::class, null, ['is_creation' => true]);

        // Vérifier que les champs 'username', 'plainPassword', 'email' et 'roles' sont présents dans le formulaire
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
