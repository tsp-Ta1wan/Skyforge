<?php

namespace App\Entity;

use App\Repository\PieceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PieceRepository::class)]
class Piece
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $description = null;

    #[ORM\Column(length: 255)]
    private ?string $type = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $acquired = null;

    #[ORM\Column(length: 255)]
    private ?string $era = null;

    #[ORM\ManyToOne(inversedBy: 'Pieces')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Arsenal $arsenal = null;

    /**
     * @var Collection<int, Hall>
     */
    #[ORM\ManyToMany(targetEntity: Hall::class, mappedBy: 'pieces')]
    private Collection $halls;

    public function __construct()
    {
        $this->halls = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
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

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function getAcquired(): ?\DateTimeInterface
    {
        return $this->acquired;
    }

    public function setAcquired(\DateTimeInterface $acquired): static
    {
        $this->acquired = $acquired;

        return $this;
    }

    public function getEra(): ?string
    {
        return $this->era;
    }

    public function setEra(string $era): static
    {
        $this->era = $era;

        return $this;
    }

    public function getArsenal(): ?Arsenal
    {
        return $this->arsenal;
    }

    public function setArsenal(?Arsenal $arsenal): static
    {
        $this->arsenal = $arsenal;

        return $this;
    }

    /**
     * @return Collection<int, Hall>
     */
    public function getHalls(): Collection
    {
        return $this->halls;
    }

    public function addHall(Hall $hall): static
    {
        if (!$this->halls->contains($hall)) {
            $this->halls->add($hall);
            $hall->addPiece($this);
        }

        return $this;
    }

    public function removeHall(Hall $hall): static
    {
        if ($this->halls->removeElement($hall)) {
            $hall->removePiece($this);
        }

        return $this;
    }
}
