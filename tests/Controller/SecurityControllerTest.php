<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityControllerTest extends WebTestCase
{
    public function testLoginPage()
    {
        // Créez une instance du client HTTP
        $client = static::createClient();

        // Créer un mock pour AuthenticationUtils
        $authenticationUtils = $this->createMock(AuthenticationUtils::class);

        // Configurer les méthodes mockées
        $authenticationUtils->method('getLastUsername')->willReturn('');
        $authenticationUtils->method('getLastAuthenticationError')->willReturn(null);

        // Remplacez le service AuthenticationUtils dans le conteneur
        $client->getContainer()->set('security.authentication_utils', $authenticationUtils);

        // Faites une requête GET vers la route /login
        $client->request('GET', '/login');

        // Vérifiez que la réponse a le statut 200
        $this->assertResponseIsSuccessful();

        // Vérifiez que le titre de la page contient "Connexion - To Do List"
        $this->assertSelectorTextContains('title', 'Connexion - To Do List');

        // Vérifiez que la réponse contient le bon contenu
        $this->assertSelectorTextContains('h1', 'Connexion');

        // Vérifiez que le formulaire contient le bon champ pour le nom d'utilisateur
        $this->assertSelectorExists('input#username');
        $this->assertSelectorExists('input#password');

        // Vérifiez que le bouton de soumission est présent
        $this->assertSelectorExists('button[type="submit"]');
        $this->assertSelectorTextContains('button[type="submit"]', 'Se connecter');
    }
}
