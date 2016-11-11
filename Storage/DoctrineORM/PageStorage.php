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
    private $pageRepository;

    /**
     * @param EntityManagerInterface $entityManager
     * @param string                 $pageClass
     */
    public function __construct(EntityManagerInterface $entityManager, string $pageClass)
    {
        $this->entityManager = $entityManager;
        $this->pageRepository = $this->entityManager->getRepository($pageClass);
    }

    /**
     * {@inheritdoc}
     */
    public function getAll(): array
    {
        return $this->pageRepository->findAll();
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

    /**
     * {@inheritdoc}
     */
    public function clearAll(): PageStorageInterface
    {
        $this->pageRepository->createQueryBuilder('p')
            ->delete()
            ->getQuery()
            ->execute()
        ;

        return $this;
    }
}
