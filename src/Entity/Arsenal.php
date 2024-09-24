<?php

namespace App\Entity;

use App\Repository\ArsenalRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ArsenalRepository::class)]
class Arsenal
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $description = null;

    /**
     * @var Collection<int, Piece>
     */
    #[ORM\OneToMany(targetEntity: Piece::class, mappedBy: 'arsenal', orphanRemoval: true)]
    private Collection $Pieces;

    public function __construct()
    {
        $this->Pieces = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Collection<int, Piece>
     */
    public function getPieces(): Collection
    {
        return $this->Pieces;
    }

    public function addPiece(Piece $piece): static
    {
        if (!$this->Pieces->contains($piece)) {
            $this->Pieces->add($piece);
            $piece->setArsenal($this);
        }

        return $this;
    }

    public function removePiece(Piece $piece): static
    {
        if ($this->Pieces->removeElement($piece)) {
            // set the owning side to null (unless already changed)
            if ($piece->getArsenal() === $this) {
                $piece->setArsenal(null);
            }
        }

        return $this;
    }
}
