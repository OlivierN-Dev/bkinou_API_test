<?php

namespace App\Controller;

use App\Entity\Story;
use App\Repository\StoryRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\RecordingRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;

final class StoryController extends AbstractController
{
    #[Route('/story',name:"app_story_index", methods:["GET"])]
    public function getStory(StoryRepository $story_repository)
    {
        return $this->json([
            "response" => "success",
            "data" => $story_repository->getAllStories()
        ]);
    }

    #[Route('/api/story',name:"app_story_create", methods:["POST"])]
    public function createStory(Request $request,EntityManagerInterface $em):JsonResponse
    {
        // récupération de toutes les données qui se trouve dans le body envoyé par l'utilisateur
        $data = $request->toArray();

        $story = new Story();
        $story->setTitle($data['title'] ?? null);
        $story->setEan($data['setEan']?? null);

        $em->persist($story);
        $em->flush();
        return $this->json([
            "response" => "success",
            "message" => "story crée avec succes"
        ],201);
    }
}
