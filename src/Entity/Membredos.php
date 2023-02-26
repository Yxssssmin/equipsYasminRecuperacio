<?php

namespace App\Entity;

use App\Repository\MembredosRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: MembredosRepository::class)]
class Membredos
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    #[Assert\NotBlank]
    private ?string $nom = null;

    #[ORM\Column(length: 100)]
    #[Assert\NotBlank]
    private ?string $cognoms = null;

    #[ORM\Column(length: 150, unique: true)]
    #[Assert\NotBlank]
    #[Assert\Email(message: "L'email {{ value }} no és vàlid")]
    private ?string $email = null;

    #[ORM\Column(length: 255)]
    private ?string $imatge_perfil = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $data_naixement = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 2, scale: '0', nullable: true)]
    #[Assert\NotBlank]
    #[Assert\Range(
        min: 0,
        minMessage: 'La nota {{ value }} ha de ser major que 0',
    )]
    #[Assert\Range(
        max: 10,
        maxMessage: 'La nota {{ value }} ha de ser menor que 10',
    )]
    private ?string $nota = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    #[Assert\NotBlank]
    private ?Equip $equip = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): self
    {
        $this->id = $id;

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

    public function getCognoms(): ?string
    {
        return $this->cognoms;
    }

    public function setCognoms(string $cognoms): self
    {
        $this->cognoms = $cognoms;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getImatgePerfil(): ?string
    {
        return $this->imatge_perfil;
    }

    public function setImatgePerfil(string $imatge_perfil): self
    {
        $this->imatge_perfil = $imatge_perfil;

        return $this;
    }

    public function getDataNaixement(): ?\DateTimeInterface
    {
        return $this->data_naixement;
    }

    public function setDataNaixement(\DateTimeInterface $data_naixement): self
    {
        $this->data_naixement = $data_naixement;

        return $this;
    }

    public function getNota(): ?string
    {
        return $this->nota;
    }

    public function setNota(?string $nota): self
    {
        $this->nota = $nota;

        return $this;
    }

    public function getEquip(): ?Equip
    {
        return $this->equip;
    }

    public function setEquip(?Equip $equip): self
    {
        $this->equip = $equip;

        return $this;
    }
}
