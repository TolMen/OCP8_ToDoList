<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityControllerTest extends WebTestCase
{
    /**
     * Teste la page de connexion de l'application.
     *
     * Test de type : Unitaire & Fonctionnel
     *
     * Cette méthode simule une requête GET vers la route de connexion 
     * (/login) et vérifie que la réponse est réussie (statut 200), 
     * que le titre de la page contient "Connexion - To Do List", 
     * et que la page affiche le bon contenu, y compris les 
     * champs du formulaire pour le nom d'utilisateur et le mot de passe, 
     * ainsi que le bouton de soumission.
     */
    public function testLoginPage()
    {
        $client = static::createClient();
        $authenticationUtils = $this->createMock(AuthenticationUtils::class);

        $authenticationUtils->method('getLastUsername')->willReturn('');
        $authenticationUtils->method('getLastAuthenticationError')->willReturn(null);

        $client->getContainer()->set('security.authentication_utils', $authenticationUtils);

        $client->request('GET', '/login');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('title', 'Connexion - To Do List');
        $this->assertSelectorTextContains('h1', 'Connexion');
        $this->assertSelectorExists('input#username');
        $this->assertSelectorExists('input#password');
        $this->assertSelectorExists('button[type="submit"]');
        $this->assertSelectorTextContains('button[type="submit"]', 'Se connecter');
    }
}
