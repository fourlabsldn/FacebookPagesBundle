<?php

namespace FL\FacebookPagesBundle\Storage\DoctrineORM;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use FL\FacebookPagesBundle\Model\PageInterface;
use FL\FacebookPagesBundle\Storage\PageStorageInterface;

class PageStorage implements PageStorageInterface
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @var EntityRepository
     */
    private $pageStorageRepository;

    /**
     * @param EntityManagerInterface $entityManager
     * @param string                 $pageStorageClass
     */
    public function __construct(EntityManagerInterface $entityManager, string $pageStorageClass)
    {
        $this->entityManager = $entityManager;
        $this->pageStorageRepository = $this->entityManager->getRepository($pageStorageClass);
    }

    /**
     * {@inheritdoc}
     */
    public function getAll(): array
    {
        return $this->pageStorageRepository->findAll();
    }

    /**
     * {@inheritdoc}
     */
    public function persist(PageInterface $page): PageStorageInterface
    {
        $this->entityManager->clear();
        $this->entityManager->persist($page);
        $this->entityManager->flush();

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function persistMultiple(array $pages): PageStorageInterface
    {
        $this->entityManager->clear();
        foreach ($pages as $page) {
            if (!($page instanceof PageInterface)) {
                throw new \InvalidArgumentException();
            }
            $this->entityManager->persist($page);
        }
        $this->entityManager->flush();

        return $this;
    }
}
