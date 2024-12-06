<?php

namespace App\Entity;

use App\Enum\SessionType;
use App\Repository\SessionRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SessionRepository::class)]
class Session
{

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(enumType: SessionType::class)]
    private ?SessionType $type = null;

    #[ORM\Column(length: 255)]
    private ?string $trainer = null;

    #[ORM\Column(type: 'datetime')]
    private ?\DateTimeInterface $time = null;

    #[ORM\Column]
    private ?int $duration = null;

    #[ORM\Column]
    private ?float $price = null;

    #[ORM\Column(name: 'is_available')]
    private ?bool $isAvailable = true;

    // #[ORM\Column(name: 'created_at', type: Types::DATETIME_IMMUTABLE)]
    // #[Gedmo\Timestampable(on: 'create')]
    // public ?\DateTimeImmutable $createdAt = null;

    // #[ORM\Column(name: 'updated_at', type: Types::DATETIME_IMMUTABLE)]
    // #[Gedmo\Timestampable(on: 'change', value: true)]
    // public ?\DateTimeImmutable $updatedAt = null;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getType(): ?SessionType
    {
        return $this->type;
    }

    public function setType(SessionType $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function getTrainer(): ?string
    {
        return $this->trainer;
    }

    public function setTrainer(string $trainer): static
    {
        $this->trainer = $trainer;
        return $this;
    }

    public function getTime(): ?\DateTimeInterface
    {
        return $this->time;
    }

    public function setTime(\DateTimeInterface $time): static
    {
        $this->time = $time;
        return $this;
    }

    public function getDuration(): ?int
    {
        return $this->duration;
    }

    public function setDuration(int $duration): static
    {
        $this->duration = $duration;
        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;
        return $this;
    }

    public function getIsAvailable(): ?bool
    {
        return $this->isAvailable;
    }

    public function setIsAvailable(bool $isAvailable): static
    {
        $this->isAvailable = $isAvailable;
        return $this;
    }
}
