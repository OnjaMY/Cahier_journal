<?php

namespace App\Entity;

use App\Repository\EnseignantRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EnseignantRepository::class)
 */
class Enseignant
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=128)
     */
    private $UID;

    /**
     * @ORM\Column(type="string", length=32)
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=32)
     */
    private $prenom;

    /**
     * @ORM\Column(type="string", length=13)
     */
    private $telephone;

    /**
     * @ORM\Column(type="string", length=128)
     */
    private $mail;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUID(): ?string
    {
        return $this->UID;
    }

    public function setUID(string $UID): self
    {
        $this->UID = $UID;

        return $this;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getTelephone(): ?int
    {
        return $this->telephone;
    }

    public function setTelephone(int $telephone): self
    {
        $this->telephone = $telephone;

        return $this;
    }

    public function getMail(): ?string
    {
        return $this->mail;
    }

    public function setMail(string $mail): self
    {
        $this->mail = $mail;

        return $this;
    }
}
