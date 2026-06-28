<?php

namespace App\Entity;

use App\Repository\StoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Ignore;
use Symfony\Bridge\Doctrine\Types\UuidType;
use Symfony\Component\Uid\Uuid;
#[ORM\Entity(repositoryClass: StoryRepository::class)]
class Story
{
    #[ORM\Id]
    #[ORM\Column(type: UuidType::NAME, unique: true)]
    private Uuid $id;

    #[ORM\Column(nullable: false)]
    private ?string $title = null;

    #[ORM\Column(length: 13)]
    private ?string $ean = null;

    /**
     * @var Collection<int, Recording>
     */
    #[ORM\OneToMany(targetEntity: Recording::class, mappedBy: 'story')]
    #[Ignore]
    private Collection $recordings;

    public function __construct()
    {
        $this->id = Uuid::v7();
        $this->recordings = new ArrayCollection();
    }

    public function getId(): Uuid
    {
        return $this->id;
    }
    public function getTitle(): ?string
    {
        return $this->title;
    }
    public function getEan(): ?string
    {
        return $this->ean;
    }
    public function setTitle(string $title): static
    {
        $this->title = $title;
        return $this;
    }
    public function setEan(string $ean): static
    {
        $this->ean = $ean;
        return $this;
    }

    /**
     * @return Collection<int, Recording>
     */
    public function getRecordings(): Collection
    {
        return $this->recordings;
    }

    public function addRecording(Recording $recording): static
    {
        if (!$this->recordings->contains($recording)) {
            $this->recordings->add($recording);
            $recording->setStory($this);
        }

        return $this;
    }

    public function removeRecording(Recording $recording): static
    {
        if ($this->recordings->removeElement($recording)) {
            if ($recording->getStory() === $this) {
                $recording->setStory(null);
            }
        }

        return $this;
    }
}