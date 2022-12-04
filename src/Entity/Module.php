<?php

namespace App\Entity;

use App\Repository\ModuleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ModuleRepository::class)]
class Module
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $titreMod = null;

    #[ORM\ManyToOne(inversedBy: 'associer')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Categorie $categorie = null;

    #[ORM\OneToMany(mappedBy: 'progMod', targetEntity: Programmer::class, orphanRemoval: true)]
    private Collection $programmers;

    public function __construct()
    {
        $this->programmers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitreMod(): ?string
    {
        return $this->titreMod;
    }

    public function setTitreMod(string $titreMod): self
    {
        $this->titreMod = $titreMod;

        return $this;
    }

    public function getCategorie(): ?Categorie
    {
        return $this->categorie;
    }

    public function setCategorie(?Categorie $categorie): self
    {
        $this->categorie = $categorie;

        return $this;
    }

    /**
     * @return Collection<int, Programmer>
     */
    public function getProgrammers(): Collection
    {
        return $this->programmers;
    }

    public function addProgrammer(Programmer $programmer): self
    {
        if (!$this->programmers->contains($programmer)) {
            $this->programmers->add($programmer);
            $programmer->setProgMod($this);
        }

        return $this;
    }

    public function removeProgrammer(Programmer $programmer): self
    {
        if ($this->programmers->removeElement($programmer)) {
            // set the owning side to null (unless already changed)
            if ($programmer->getProgMod() === $this) {
                $programmer->setProgMod(null);
            }
        }

        return $this;
    }
}
