<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{
    /**
     * Teste la page d'accueil de l'application.
     *
     * Test de type : Unitaire & Fonctionnel
     *
     * Cette méthode simule une requête GET à la page d'accueil, 
     * vérifie que la réponse est réussie, que le titre de la page 
     * contient "Accueil - To Do List", que le texte dans les 
     * éléments h1 et p correspond aux attentes, et qu'un lien 
     * vers la liste des tâches existe. Elle vérifie également 
     * que la redirection vers la liste des tâches fonctionne.
     */
    public function testIndex()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/');

        $this->assertResponseIsSuccessful();
        $this->assertPageTitleContains('Accueil - To Do List');
        $this->assertSelectorTextContains('h1', 'Bienvenue sur To do List');
        $this->assertSelectorTextContains('p.lead', 'Gérez facilement toutes vos tâches en un seul endroit.');
        $this->assertSelectorExists('a.btn.btn-primary.btn-lg.mt-3');

        $link = $crawler->selectLink('Voir la liste des tâches')->link();
        $crawler = $client->click($link);

        $this->assertResponseIsSuccessful();
        $this->assertPageTitleContains('Liste des tâches');
    }
}
