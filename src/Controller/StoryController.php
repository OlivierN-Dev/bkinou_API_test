<?php

namespace App\Controller;

use App\Service\StoryService;
use App\Repository\StoryRepository;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;

final class StoryController extends AbstractController
{

    public function __construct(private StoryService $story_service){}
    #[Route('/story',name:"app_story_index", methods:["GET"])]
    public function getStory(): JsonResponse
    {
        $data = $this->story_service->StoryData();
        return $this->json([
            "response" => "success",
            "data" => $data 
        ]);
    }

    #[Route('/api/story',name:"app_story_create", methods:["POST"])]
    public function StoryPOST(Request $request,):JsonResponse
    {
        // récupération de toutes les données qui se trouve dans le body envoyé par l'utilisateur
        $body = $request->toArray();
        $data = $this->story_service->createRecording($body);
        if(!$data) {
            return $this->json([
                "response" => "error",
                "message" => "Erreur lros de la création de la story"
            ],500);
        }
        return $this->json([
            "response" => "success",
            "message" => "story crée avec succes"
        ],201);
    }

    #[Route('/api/stories/{id}',name: "app_story_records_id",methods:["GET"])]
    public function RecordsByStoryId(Request $request): JsonResponse
    {
        $storyId = $request->attributes->get('id');
        $data = $this->story_service->getRecordsByStoryId($storyId);
        return $this->json([
            'data' => $data
        ],200);
    }
}
