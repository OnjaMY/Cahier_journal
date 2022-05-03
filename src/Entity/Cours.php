<?php

namespace App\Entity;

use App\Repository\CoursRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CoursRepository::class)
 */
class Cours
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $seance;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $heureDebut;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $heureFin;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSeance(): ?string
    {
        return $this->seance;
    }

    public function setSeance(string $seance): self
    {
        $this->seance = $seance;

        return $this;
    }

    public function getHeureDebut(): ?string
    {
        return $this->heureDebut;
    }

    public function setHeureDebut(string $heureDebut): self
    {
        $this->heureDebut = $heureDebut;

        return $this;
    }

    public function getHeureFin(): ?string
    {
        return $this->heureFin;
    }

    public function setHeureFin(string $heureFin): self
    {
        $this->heureFin = $heureFin;

        return $this;
    }
}
