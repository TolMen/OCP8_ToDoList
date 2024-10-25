<?php

namespace App\Tests\Controller; // Utilise le bon namespace

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();

        // Requête GET vers la route racine
        $crawler = $client->request('GET', '/');

        // Vérifie que la réponse a un code de statut 200
        $this->assertResponseIsSuccessful(); // Méthode plus propre que assertEquals(200, ...)

        // Vérifie que le texte "Welcome to Symfony" est présent dans l'H1
        $this->assertSelectorTextContains('h1', 'Welcome to Symfony');
    }
}
