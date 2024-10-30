<?php

namespace App\Tests\Repository;

use App\Entity\Tag;
use App\Repository\TagRepository;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class TagRepositoryTest extends KernelTestCase
{
    private TagRepository $tagRepository;

    protected function setUp(): void
    {
        // Démarre le noyau Symfony pour avoir accès au conteneur
        self::bootKernel();

        // Récupère le repository depuis le conteneur
        $this->tagRepository = static::getContainer()->get(TagRepository::class);
    }

    public function testAddTag(): void
    {
        // Crée un nouveau tag
        $tag = new Tag();
        $tag->setName('Symfony');

        // Persiste et flush le tag
        $entityManager = $this->tagRepository->getEntityManager();
        $entityManager->persist($tag);
        $entityManager->flush();

        // Vérifie que le tag a bien été ajouté
        $this->assertNotNull($tag->getId());
    }

    public function testFindTagById(): void
    {
        // Crée et persiste un tag pour le test
        $tag = new Tag();
        $tag->setName('Doctrine');
        $entityManager = $this->tagRepository->getEntityManager();
        $entityManager->persist($tag);
        $entityManager->flush();

        // Cherche le tag par son ID
        $foundTag = $this->tagRepository->find($tag->getId());

        // Vérifie que le tag récupéré correspond au tag créé
        $this->assertInstanceOf(Tag::class, $foundTag);
        $this->assertEquals('Doctrine', $foundTag->getName());
    }
}
