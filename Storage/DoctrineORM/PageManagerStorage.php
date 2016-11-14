<?php

namespace FL\FacebookPagesBundle\Storage\DoctrineORM;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use FL\FacebookPagesBundle\Model\PageManagerInterface;
use FL\FacebookPagesBundle\Storage\PageManagerStorageInterface;

class PageManagerStorage implements PageManagerStorageInterface
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @var EntityRepository
     */
    private $pageManagerRepository;

    /**
     * @param EntityManagerInterface $entityManager
     * @param string                 $pageManagerClass
     */
    public function __construct(EntityManagerInterface $entityManager, string $pageManagerClass)
    {
        $this->entityManager = $entityManager;
        $this->pageManagerRepository = $this->entityManager->getRepository($pageManagerClass);
    }

    /**
     * {@inheritdoc}
     */
    public function getAll(): array
    {
        return $this->pageManagerRepository->findAll();
    }

    /**
     * {@inheritdoc}
     */
    public function persist(PageManagerInterface $pageManager): PageManagerStorageInterface
    {
        $this->entityManager->clear();
        $this->entityManager->persist($pageManager);
        $this->entityManager->flush();

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function persistMultiple(array $pageManagers): PageManagerStorageInterface
    {
        $this->entityManager->clear();
        foreach ($pageManagers as $user) {
            if (!($user instanceof PageManagerInterface)) {
                throw new \InvalidArgumentException();
            }
            $this->entityManager->persist($user);
        }
        $this->entityManager->flush();

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function clearAll(): PageManagerStorageInterface
    {
        $this->pageManagerRepository->createQueryBuilder('m')
            ->delete()
            ->getQuery()
            ->execute()
        ;

        return $this;
    }
}
