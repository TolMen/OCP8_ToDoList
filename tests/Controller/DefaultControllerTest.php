<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{
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
