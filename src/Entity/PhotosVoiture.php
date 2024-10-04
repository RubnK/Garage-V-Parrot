<?php

namespace App\Entity;

use App\Repository\PhotosVoitureRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PhotosVoitureRepository::class)]
class PhotosVoiture
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $id_voiture = null;

    #[ORM\Column(length: 255)]
    private ?string $dir = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): static
    {
        $this->id = $id;

        return $this;
    }

    public function getIdVoiture(): ?int
    {
        return $this->id_voiture;
    }

    public function setIdVoiture(int $id_voiture): static
    {
        $this->id_voiture = $id_voiture;

        return $this;
    }

    public function getDir(): ?string
    {
        return $this->dir;
    }

    public function setDir(string $dir): static
    {
        $this->dir = $dir;

        return $this;
    }
}
