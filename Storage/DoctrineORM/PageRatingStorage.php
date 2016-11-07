<?php

namespace FL\FacebookPagesBundle\Storage\DoctrineORM;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use FL\FacebookPagesBundle\Model\PageRatingInterface;
use FL\FacebookPagesBundle\Storage\PageRatingStorageInterface;

class PageRatingStorage implements PageRatingStorageInterface
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @var EntityRepository
     */
    private $pageRatingRepository;

    /**
     * @param EntityManagerInterface $entityManager
     * @param string                 $pageRatingClass
     */
    public function __construct(EntityManagerInterface $entityManager, string $pageRatingClass)
    {
        $this->entityManager = $entityManager;
        $this->pageRatingRepository = $this->entityManager->getRepository($pageRatingClass);
    }

    /**
     * {@inheritdoc}
     */
    public function getAll(): array
    {
        return $this->pageRatingRepository->findAll();
    }

    /**
     * {@inheritdoc}
     */
    public function persist(PageRatingInterface $pageRating): PageRatingStorageInterface
    {
        $this->entityManager->clear();
        $this->entityManager->persist($pageRating);
        $this->entityManager->flush();

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function persistMultiple(array $pageRatings): PageRatingStorageInterface
    {
        $this->entityManager->clear();
        foreach ($pageRatings as $rating) {
            if (!($rating instanceof PageRatingInterface)) {
                throw new \InvalidArgumentException();
            }
            $this->entityManager->persist($rating);
        }
        $this->entityManager->flush();

        return $this;
    }
}
