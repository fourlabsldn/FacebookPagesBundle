<?php

namespace FL\FacebookPagesBundle\Tests\Util\Storage\DoctrineORM;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use PHPUnit\Framework\TestCase;

class ManagerAndRepositoryTest extends TestCase
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
            ->expects(static::any())
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
            ->expects(static::any())
            ->method('clear')
            ->willReturnCallback(function () {
                $this->persistedEntities = [];
            });

        $this->entityManager
            ->expects(static::any())
            ->method('persist')
            ->willReturnCallback(function ($entity) {
                $this->persistedEntities[] = $entity;
            });

        $this->entityManager
            ->expects(static::any())
            ->method('flush')
            ->willReturnCallback(function () {
                $this->persistedAndFlushedEntities = array_merge($this->persistedAndFlushedEntities, $this->persistedEntities);
            });

        $this->entityManager
            ->expects(static::any())
            ->method('getRepository')
            ->will(static::returnValue($this->entityRepository))
        ;
    }
}
