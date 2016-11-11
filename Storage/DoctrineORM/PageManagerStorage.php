<?php

namespace FL\FacebookPagesBundle\Storage\DoctrineORM;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use FL\FacebookPagesBundle\Model\FacebookUserInterface;
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
    private $facebookUserRepository;

    /**
     * @param EntityManagerInterface $entityManager
     * @param string                 $facebookUserClass
     */
    public function __construct(EntityManagerInterface $entityManager, string $facebookUserClass)
    {
        $this->entityManager = $entityManager;
        $this->facebookUserRepository = $this->entityManager->getRepository($facebookUserClass);
    }

    /**
     * {@inheritdoc}
     */
    public function getAll(): array
    {
        return $this->facebookUserRepository->findAll();
    }

    /**
     * {@inheritdoc}
     */
    public function persist(FacebookUserInterface $facebookUser): PageManagerStorageInterface
    {
        $this->entityManager->clear();
        $this->entityManager->persist($facebookUser);
        $this->entityManager->flush();

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function persistMultiple(array $facebookUsers): PageManagerStorageInterface
    {
        $this->entityManager->clear();
        foreach ($facebookUsers as $user) {
            if (!($user instanceof FacebookUserInterface)) {
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
        $this->facebookUserRepository->createQueryBuilder('m')
            ->delete()
            ->getQuery()
            ->execute()
        ;

        return $this;
    }
}