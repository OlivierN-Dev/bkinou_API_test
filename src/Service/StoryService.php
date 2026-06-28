<?php

namespace App\Service;

use App\Entity\Recording;
use App\Entity\Story;
use App\Repository\StoryRepository;
use Symfony\Component\Uid\Uuid;
use Doctrine\ORM\EntityManagerInterface;
class StoryService {

    public function __construct(private StoryRepository $story_repository,private EntityManagerInterface $em) {}

    public function createRecording(array $data)
    {
        // récupération de toutes les données qui se trouve dans le body envoyé par l'utilisateur
        $story = new Story();
        $story->setTitle($data['title'] ?? null);
        $story->setEan($data['setEan']?? null);

        $this->em->persist($story);
        $this->em->flush();
    }

    public function StoryData() {
        $data = array_map(function (Story $s) {
            $r = $s->getRecordings();
            return [
                'id' => $s->getId(),
                'title' => $s->getTitle(),
                'ean' => $s->getEan(),

                // ici on refait un array_map sur tout les elements de la collection recupérer $r on la transforme en Array puis on recupere les elements avec ->getId() ...
                "records" => array_map(function (Recording $record) {
                    return [
                        'id' => $record->getId(),
                        'title' => $record->getAudioKey(),
                        'ean' => $record->getNarrator(),
                        'createdAt'=> $record->getCreatedAt()?->format('Y-m-d H:i:s'),
                    ];
                }, $r->toArray())
            ];
        }, $this->story_repository->getAllStories());
        return $data;
    }
    public function getRecordsByStoryId(string $id){
        $story = $this->story_repository->find($id);
        $data = array_map(function (Recording $record) {
            return [
                'id' => $record->getId(),
                'title' => $record->getAudioKey(),
                'ean' => $record->getNarrator(),
                'createdAt'=> $record->getCreatedAt()?->format('Y-m-d H:i:s'),
            ];
        },$story->getRecordings()->toArray());
        return $data;
    }
}