<?php

namespace App\Entity;

use App\Entity\Module;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\CategorieRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

#[ORM\Entity(repositoryClass: CategorieRepository::class)]
class Categorie
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $titreCat = null;

    #[ORM\OneToMany(mappedBy: 'categorie', targetEntity: Module::class, orphanRemoval: true)]
    private Collection $associer;

    public function __construct()
    {
        $this->associer = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitreCat(): ?string
    {
        return $this->titreCat;
    }

    public function setTitreCat(string $titreCat): self
    {
        $this->titreCat = $titreCat;

        return $this;
    }

    /**
     * @return Collection<int, Module>
     */
    public function getAssocier(): Collection
    {
        return $this->associer;
    }

    public function addAssocier(Module $associer): self
    {
        if (!$this->associer->contains($associer)) {
            $this->associer->add($associer);
            $associer->setCategorie($this);
        }

        return $this;
    }

    public function removeAssocier(Module $associer): self
    {
        if ($this->associer->removeElement($associer)) {
            // set the owning side to null (unless already changed)
            if ($associer->getCategorie() === $this) {
                $associer->setCategorie(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->titreCat;
    }
}
