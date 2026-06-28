<?php

namespace App\Service;

use Psr\Log\LoggerInterface;

class NotificationService {
    public function __construct(private LoggerInterface $logger){}

    public function recordingNotification(string $audioKey, string $title): void
    {
        $this->logger->info(
            'Nouvel enregistrement créé : {audioKey} pour la story {title}',
            [
                'audioKey' => $audioKey,
                'title' => $title,
            ]
        );
    }
}