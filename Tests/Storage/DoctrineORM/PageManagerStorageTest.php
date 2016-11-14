<?php

namespace FL\FacebookPagesBundle\Tests\Storage\DoctrineORM;

use FL\FacebookPagesBundle\Model\PageManager;
use FL\FacebookPagesBundle\Model\PageManagerInterface;
use FL\FacebookPagesBundle\Storage\DoctrineORM\FacebookUserStorage;
use FL\FacebookPagesBundle\Storage\DoctrineORM\PageManagerStorage;
use FL\FacebookPagesBundle\Tests\Util\Storage\DoctrineORM\ManagerAndRepositoryTest;

class PageManagerStorageTest extends ManagerAndRepositoryTest
{
    public function setUp()
    {
        $this->findAllReturnValue = [new PageManager(), new PageManager()];
        parent::setUp();
    }

    /**
     * @test
     * @covers \FL\FacebookPagesBundle\Storage\DoctrineORM\FacebookUserStorage::__construct
     * @covers \FL\FacebookPagesBundle\Storage\DoctrineORM\FacebookUserStorage::getAll
     */
    public function testGetAll()
    {
        $facebookUserStorage = new PageManagerStorage(
            $this->entityManager,
            PageManager::class
        );
        $this->assertInternalType('array', $facebookUserStorage->getAll());
        foreach ($facebookUserStorage->getAll() as $facebookUser) {
            $this->assertInstanceOf(PageManagerInterface::class, $facebookUser);
        }
    }

    /**
     * @test
     * @covers \FL\FacebookPagesBundle\Storage\DoctrineORM\FacebookUserStorage::__construct
     * @covers \FL\FacebookPagesBundle\Storage\DoctrineORM\FacebookUserStorage::persist
     */
    public function testPersist()
    {
        $facebookUserStorage = new PageManagerStorage(
            $this->entityManager,
            PageManagerStorage::class
        );

        $facebookUserA = new PageManager();
        $facebookUserStorage->persist($facebookUserA);
        $this->assertContains($facebookUserA, $this->persistedEntities);
        $this->assertContains($facebookUserA, $this->persistedAndFlushedEntities);

        $facebookUserB = new PageManager();
        $facebookUserStorage->persist($facebookUserB);
        $this->assertNotContains($facebookUserA, $this->persistedEntities);
        $this->assertContains($facebookUserB, $this->persistedEntities);
        $this->assertContains($facebookUserA, $this->persistedAndFlushedEntities);
        $this->assertContains($facebookUserB, $this->persistedAndFlushedEntities);
    }

    /**
     * @test
     * @covers \FL\FacebookPagesBundle\Storage\DoctrineORM\FacebookUserStorage::__construct
     * @covers \FL\FacebookPagesBundle\Storage\DoctrineORM\FacebookUserStorage::persistMultiple
     */
    public function testPersistMultiple()
    {
        $facebookUserStorage = new PageManagerStorage(
            $this->entityManager,
            PageManagerStorage::class
        );

        $facebookUserA = new PageManager();
        $facebookUserB = new PageManager();

        $facebookUserStorage->persistMultiple([$facebookUserA, $facebookUserB]);
        $this->assertContains($facebookUserA, $this->persistedEntities);
        $this->assertContains($facebookUserB, $this->persistedEntities);
        $this->assertContains($facebookUserA, $this->persistedAndFlushedEntities);
        $this->assertContains($facebookUserB, $this->persistedAndFlushedEntities);
    }

    /**
     * @test
     * @covers \FL\FacebookPagesBundle\Storage\DoctrineORM\FacebookUserStorage::persistMultiple
     */
    public function testPersistMultipleException()
    {
        $facebookUserStorage = new PageManagerStorage(
            $this->entityManager,
            PageManagerStorage::class
        );

        $facebookUser = new PageManager();
        $date = new \DateTimeImmutable();

        try {
            $facebookUserStorage->persistMultiple([$facebookUser, $date]);
        } catch (\InvalidArgumentException $exception) {
            return;
        }

        $this->fail(sprintf(
            'Expected %s for invalid %s::persistMultiple',
            \InvalidArgumentException::class,
            PageManager::class
        ));
    }
}
