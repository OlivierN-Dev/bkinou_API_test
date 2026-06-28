<?php

namespace App\Controller;

use App\Service\RecordingService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

final class RecordingController extends AbstractController
{
    #[Route('/recording', name: 'app_recording_index', methods: ['GET'])]
    public function index(RecordingService $recording_service): JsonResponse
    {
        $data = $recording_service->renderRecordingData();
        return $this->json(["response" => "success",'data' => $data]);
    }

    #[Route('/api/recordings', name: 'app_recording_create', methods: ['POST'])]
    public function createRecording(Request $request,RecordingService $recording_service): JsonResponse
    {
        // récupération de toutes les données situées dans le post
        $data = $request->toArray();

        $response = $recording_service->createRecording($data);
        if($response)
        {
            return  $this->json([
                'response' => 'failed',
                'message' => "erreur lors de la création de l'enregistrement"
            ]);
        }
        return $this->json(
            ["response" => "success", "message" => $response]
        );
    }
}