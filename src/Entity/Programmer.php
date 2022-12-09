<?php

namespace App\Entity;

use App\Repository\ProgrammerRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProgrammerRepository::class)]
class Programmer
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $duree = null;

    #[ORM\ManyToOne(inversedBy: 'programmers')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Session $progSes = null;

    #[ORM\ManyToOne(inversedBy: 'programmers')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Module $progMod = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDuree(): ?int
    {
        return $this->duree;
    }

    public function setDuree(int $duree): self
    {
        $this->duree = $duree;

        return $this;
    }

    public function getProgSes(): ?Session
    {
        return $this->progSes;
    }

    public function setProgSes(?Session $progSes): self
    {
        $this->progSes = $progSes;

        return $this;
    }

    public function getProgMod(): ?Module
    {
        return $this->progMod;
    }

    public function setProgMod(?Module $progMod): self
    {
        $this->progMod = $progMod;

        return $this;
    }

    // public function __toString()
    // {
    //     return $this->progMod;
    // }
}
