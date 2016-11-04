<?php

namespace FL\FacebookPagesBundle\Tests\Storage\DoctrineORM;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use FL\FacebookPagesBundle\Model\FacebookUser;
use FL\FacebookPagesBundle\Model\FacebookUserInterface;
use FL\FacebookPagesBundle\Storage\DoctrineORM\FacebookUserStorage;

class FacebookUserStorageTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var EntityRepository
     */
    private $entityRepository;

    /**
     * @var EntityManager
     */
    private $entityManager;

    public function setUp()
    {
        $this->entityRepository = $this
            ->getMockBuilder(EntityRepository::class)
            ->setMethods(['findAll'])
            ->disableOriginalConstructor()
            ->getMock()
        ;
        $this->entityRepository
            ->expects($this->any())
            ->method('findAll')
            ->will($this->returnValue([new FacebookUser(), new FacebookUser()]))
        ;

        $this->entityManager = $this
            ->getMockBuilder(EntityManager::class)
            ->setMethods(['clear', 'persist', 'flush', 'getRepository', 'getUnitOfWork'])
            ->disableOriginalConstructor()
            ->getMock()
        ;
        $this->entityManager
            ->expects($this->any())
            ->method('getRepository')
            ->will($this->returnValue($this->entityRepository))
        ;
    }

    /**
     * @test
     * @covers \FL\FacebookPagesBundle\Storage\DoctrineORM\FacebookUserStorage::getAll
     */
    public function testFindAll()
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

}