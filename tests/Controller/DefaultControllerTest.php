<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

// Classe de test pour le contrôleur par défaut
class DefaultControllerTest extends WebTestCase
{
    /**
     * Teste la page d'accueil de l'application.
     *
     * Cette méthode envoie une requête GET à la route racine de l'application 
     * et vérifie que la réponse est réussie (code de statut 200). 
     * Elle s'assure également que le texte attendu est présent dans la balise <h1> 
     * de la page, confirmant que la page d'accueil est affichée correctement.
     */
    public function testIndex()
    {
        // Création d'un client qui simulera un navigateur pour faire des requêtes HTTP
        $client = static::createClient();

        // Envoi d'une requête GET à la route racine ('/') de l'application
        $crawler = $client->request('GET', '/');

        // Vérification que la réponse du serveur est un succès (code de statut 200)
        $this->assertResponseIsSuccessful();

        // Vérification que le texte spécifique est présent dans la balise <h1> de la réponse HTML
        $this->assertSelectorTextContains(
            'h1',
            'Bienvenue sur Todo List, l\'application vous permettant de gérer l\'ensemble de vos tâches sans effort !'
        );
    }
}
