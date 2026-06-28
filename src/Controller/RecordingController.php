<?php

namespace App\Controller;

use App\Service\RecordingService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

final class RecordingController extends AbstractController
{

    public function __construct(private RecordingService $recording_service){}

    #[Route('/recording', name: 'app_recording_index', methods: ['GET'])]
    public function renderRecordingData(): JsonResponse
    {
        $data = $this->recording_service->recordingData();
        return $this->json(["response" => "success",'data' => $data]);
    }

    #[Route('/api/recordings', name: 'app_recording_create', methods: ['POST'])]
    public function Recording(Request $request,RecordingService $recording_service): JsonResponse
    {
        // récupération de toutes les données situées dans le post
        $data = $request->toArray();

        $response = $recording_service->createRecording($data);
        if(!$response)
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