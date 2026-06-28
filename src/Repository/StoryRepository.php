<?php

namespace App\Repository;

use App\Entity\Story;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Story>
 */
class StoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Story::class);
    }

    public function getAllStories(Story $story): array
    {
        return $this->json([
            'audioKey' => $story->getAudioKey(),
            'narrator' => $story->getNarrator(),
            'createdAt' => $story->getCreatedAt()?->format('Y-m-d H:i:s'),
            'story' => [
                'id' => $r->getStory()?->getId(),
                'title' => $r->getStory()?->getTitle(),
                'ean' => $r->getStory()?->getEan(),
            ]
        ],200);
    }
    public function findById(string $id): ?Story
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getOneOrNullResult();
    }
}
