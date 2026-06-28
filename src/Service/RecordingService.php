<?php

namespace App\Service;

use App\Entity\Recording;
use App\Repository\RecordingRepository;
use Symfony\Component\Uid\Uuid;
use App\Repository\StoryRepository;
use Doctrine\ORM\EntityManagerInterface;
class RecordingService {

    public function __construct(private RecordingRepository $recording_repository,private StoryRepository $storyRepository,private EntityManagerInterface $em) {}
    public function renderRecordingData()
    {
        // bouclé sur chaque elements récupérer ici ($recordingRepository->findAll()) et data = au return donc le tableau
        $data = array_map(function (Recording $r) {
            // récupération de la story qui est en rapport avec l'enregistrement
            $story = $r->getStory();

            return [
                'id' => $r->getId(),
                'audioKey' => $r->getAudioKey(),
                'narrator' => $r->getNarrator(),
                'createdAt' => $r->getCreatedAt()?->format('Y-m-d H:i:s'),
                // si story existe alors on return le tableau avec les elements sinon on return null pour evité de retourner un json avec des variables du style id : null
                'story' => $story ? [
                    'id' => $story->getId(),
                    'title' => $story->getTitle(),
                    'ean' => $story->getEan(),
                ] : null,
            ];
        }, $this->recording_repository->findAll());

        return $data;
    }

    public function createRecording(array $data)
    {
        // récupération de l'id de la story en fonction de l'id envoyé via id_story dans le body
        $story = $this->storyRepository->findById($data['id_story']);
        // SI rien n'est trouvé alors return une erreur via le json 
        if(!$story)
        {
            return;
        }
        // Création d'une nouvelle instance de la classe Recording
        $recording = new Recording();
        // on set les données du post par ceux de la table  
        $recording->setNarrator($data['narrator'] ?? null);  
        $recording->setStory($story);
        // récupération de la datetime
        $setDate = new \DateTime();
        $recording->setCreatedAt($setDate);
        // géneration de l'audio Key
        $idAudioKey = 'adkey_' . Uuid::v4()->toRfc4122();
        $recording->setAudioKey($idAudioKey);  
        // on sauvegarde recording dans la base
        $this->em->persist($recording);
        // on execute la requete dans la base
        $this->em->flush();
            return "Enregistrement Crée avec succès";
    }
}