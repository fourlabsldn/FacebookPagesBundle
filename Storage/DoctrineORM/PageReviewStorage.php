<?php

namespace FL\FacebookPagesBundle\Storage\DoctrineORM;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use FL\FacebookPagesBundle\Model\PageReviewInterface;
use FL\FacebookPagesBundle\Storage\PageReviewStorageInterface;

class PageReviewStorage implements PageReviewStorageInterface
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @var EntityRepository
     */
    private $repository;

    /**
     * @param EntityManagerInterface $entityManager
     * @param string                 $pageReviewClass
     */
    public function __construct(EntityManagerInterface $entityManager, string $pageReviewClass)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository($pageReviewClass);
    }

    /**
     * {@inheritdoc}
     */
    public function getAll(): array
    {
        return $this->repository->findAll();
    }

    /**
     * {@inheritdoc}
     */
    public function persist(PageReviewInterface $pageReview): PageReviewStorageInterface
    {
        $this->entityManager->clear();
        $this->entityManager->persist($pageReview);
        $this->entityManager->flush();

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function persistMultiple(array $pageReviews): PageReviewStorageInterface
    {
        $this->entityManager->clear();
        foreach ($pageReviews as $review) {
            if (!($review instanceof PageReviewInterface)) {
                throw new \InvalidArgumentException();
            }
            $this->entityManager->persist($review);
        }
        $this->entityManager->flush();

        return $this;
    }
}
