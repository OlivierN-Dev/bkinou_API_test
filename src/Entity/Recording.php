<?php

namespace App\Entity;

use App\Repository\RecordingRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Types\UuidType;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: RecordingRepository::class)]
class Recording
{
    #[ORM\Id]
    #[ORM\Column(type: UuidType::NAME, unique: true)]
    private Uuid $id;

    #[ORM\Column(length: 255)]
    private ?string $audioKey = null;

    #[ORM\Column]
    private ?\DateTime $createdAt = null;

    #[ORM\Column(length: 255)]
    private ?string $narrator = null;

    #[ORM\ManyToOne(inversedBy: 'recordings')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Story $story = null;

    public function __construct()
    {
        $this->id = Uuid::v7();
    }

    public function getId(): Uuid
    {
        return $this->id;
    }

    public function getAudioKey(): ?string
    {
        return $this->audioKey;
    }

    public function setAudioKey(string $audioKey): static
    {
        $this->audioKey = $audioKey;

        return $this;
    }

    public function getCreatedAt(): ?\DateTime
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTime $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getNarrator(): ?string
    {
        return $this->narrator;
    }

    public function setNarrator(string $narrator): static
    {
        $this->narrator = $narrator;

        return $this;
    }

    public function getStory(): ?Story
    {
        return $this->story;
    }

    public function setStory(?Story $story): static
    {
        $this->story = $story;

        return $this;
    }
}
