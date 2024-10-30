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
        self::bootKernel();
        $this->tagRepository = static::getContainer()->get(TagRepository::class);
    }

    /**
     * Teste l'ajout d'un nouveau tag.
     *
     * Test de type : Unitaire 
     *
     * Cette méthode crée un nouveau tag, le persiste dans 
     * la base de données et vérifie que son ID est 
     * correctement attribué après l'ajout.
     */
    public function testAddTag(): void
    {
        $tag = new Tag();
        $tag->setName('Symfony');

        $entityManager = $this->tagRepository->getEntityManager();
        $entityManager->persist($tag);
        $entityManager->flush();

        $this->assertNotNull($tag->getId());
    }

    /**
     * Teste la recherche d'un tag par son ID.
     *
     * Test de type : Unitaire 
     *
     * Cette méthode crée et persiste un tag dans la base 
     * de données, puis le recherche par son ID et vérifie 
     * que le tag récupéré correspond au tag créé.
     */
    public function testFindTagById(): void
    {
        $tag = new Tag();
        $tag->setName('Doctrine');
        $entityManager = $this->tagRepository->getEntityManager();
        $entityManager->persist($tag);
        $entityManager->flush();

        $foundTag = $this->tagRepository->find($tag->getId());

        $this->assertInstanceOf(Tag::class, $foundTag);
        $this->assertEquals('Doctrine', $foundTag->getName());
    }
}
