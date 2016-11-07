<?php

namespace FL\FacebookPagesBundle\Tests\Storage\DoctrineORM;

use FL\FacebookPagesBundle\Model\FacebookUser;
use FL\FacebookPagesBundle\Model\FacebookUserInterface;
use FL\FacebookPagesBundle\Storage\DoctrineORM\FacebookUserStorage;
use FL\FacebookPagesBundle\Tests\Util\Storage\DoctrineORM\ManagerAndRepositoryTest;

class FacebookUserStorageTest extends ManagerAndRepositoryTest
{
    public function setUp()
    {
        $this->findAllReturnValue = [new FacebookUser(), new FacebookUser()];
        parent::setUp();
    }

    /**
     * @test
     * @covers \FL\FacebookPagesBundle\Storage\DoctrineORM\FacebookUserStorage::getAll
     */
    public function testGetAll()
    {
        $facebookUserStorage = new FacebookUserStorage(
            $this->entityManager,
            FacebookUser::class
        );
        $this->assertInternalType('array', $facebookUserStorage->getAll());
        foreach ($facebookUserStorage->getAll() as $facebookUser) {
            $this->assertInstanceOf(FacebookUserInterface::class, $facebookUser);
        }
    }

    /**
     * @test
     * @covers \FL\FacebookPagesBundle\Storage\DoctrineORM\FacebookUserStorage::persist
     */
    public function testPersist()
    {
        $facebookUserStorage = new FacebookUserStorage(
            $this->entityManager,
            FacebookUserStorage::class
        );

        $facebookUserA = new FacebookUser;
        $facebookUserStorage->persist($facebookUserA);
        $this->assertContains($facebookUserA, $this->persistedEntities);
        $this->assertContains($facebookUserA, $this->persistedAndFlushedEntities);

        $facebookUserB = new FacebookUser;
        $facebookUserStorage->persist($facebookUserB);
        $this->assertNotContains($facebookUserA, $this->persistedEntities);
        $this->assertContains($facebookUserB, $this->persistedEntities);
        $this->assertContains($facebookUserA, $this->persistedAndFlushedEntities);
        $this->assertContains($facebookUserB, $this->persistedAndFlushedEntities);
    }

    /**
     * @test
     * @covers \FL\FacebookPagesBundle\Storage\DoctrineORM\FacebookUserStorage::persistMultiple
     */
    public function testPersistMultiple()
    {
        $facebookUserStorage = new FacebookUserStorage(
            $this->entityManager,
            FacebookUserStorage::class
        );

        $facebookUserA = new FacebookUser;
        $facebookUserB = new FacebookUser;

        $facebookUserStorage->persistMultiple([$facebookUserA, $facebookUserB]);
        $this->assertContains($facebookUserA, $this->persistedEntities);
        $this->assertContains($facebookUserB, $this->persistedEntities);
        $this->assertContains($facebookUserA, $this->persistedAndFlushedEntities);
        $this->assertContains($facebookUserB, $this->persistedAndFlushedEntities);
    }
}
