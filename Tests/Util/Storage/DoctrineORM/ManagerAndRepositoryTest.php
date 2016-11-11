<?php

namespace FL\FacebookPagesBundle\Tests\Util\Storage\DoctrineORM;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;

class ManagerAndRepositoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var EntityRepository
     */
    protected $entityRepository;

    /**
     * @var EntityManager
     */
    protected $entityManager;

    /**
     * Persist method on @see ManagerAndRepositoryTest::$entityManager will add an entity to $persistedEntities
     * Clear method on @see ManagerAndRepositoryTest::$entityManager will reset $persistedEntities.
     *
     * @var array
     */
    protected $persistedEntities = [];

    /**
     * Flush method on @see ManagerAndRepositoryTest::$entityManager will merge $persistedEntities into $persistedAndFlushedEntities.
     *
     * @var array
     */
    protected $persistedAndFlushedEntities = [];

    /**
     * @var array
     */
    protected $findAllReturnValue = [];

    /**
     * Set up @see ManagerAndRepositoryTest::$entityManager
     * Set up @see ManagerAndRepositoryTest::$entityRepository.
     */
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
            ->will($this->returnValue($this->findAllReturnValue))
        ;

        $this->entityManager = $this
            ->getMockBuilder(EntityManager::class)
            ->setMethods(['clear', 'persist', 'flush', 'getRepository'])
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $this->entityManager
            ->expects($this->any())
            ->method('clear')
            ->willReturnCallback(function () {
                $this->persistedEntities = [];
            });

        $this->entityManager
            ->expects($this->any())
            ->method('persist')
            ->willReturnCallback(function ($entity) {
                $this->persistedEntities[] = $entity;
            });

        $this->entityManager
            ->expects($this->any())
            ->method('flush')
            ->willReturnCallback(function () {
                $this->persistedAndFlushedEntities = array_merge($this->persistedAndFlushedEntities, $this->persistedEntities);
            });

        $this->entityManager
            ->expects($this->any())
            ->method('getRepository')
            ->will($this->returnValue($this->entityRepository))
        ;
    }
}
