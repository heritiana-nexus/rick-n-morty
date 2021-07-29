<?php

namespace App\Entity;

use App\Repository\LocationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=LocationRepository::class)
 */
class Location
{
    use BaseEntityTrait;
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=30)
     */
    private $type;

    /**
     * @ORM\Column(type="string", length=30, nullable=true)
     */
    private $dimension;

    /**
     * @ORM\OneToMany(targetEntity=Character::class, mappedBy="origin")
     */
    private $residents;

    public function __construct()
    {
        $this->residents = new ArrayCollection();
        $this->created = new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getDimension(): ?string
    {
        return $this->dimension;
    }

    public function setDimension(?string $dimension): self
    {
        $this->dimension = $dimension;

        return $this;
    }

    /**
     * @return Collection|Character[]
     */
    public function getResidents(): Collection
    {
        return $this->residents;
    }

    public function addResident(Character $resident): self
    {
        if (!$this->residents->contains($resident)) {
            $this->residents[] = $resident;
            $resident->setOrigin($this);
        }

        return $this;
    }

    public function removeResident(Character $resident): self
    {
        if ($this->residents->removeElement($resident)) {
            // set the owning side to null (unless already changed)
            if ($resident->getOrigin() === $this) {
                $resident->setOrigin(null);
            }
        }

        return $this;
    }

    public function serialize()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'type' => $this->type,
            'dimension' => $this->dimension,
        ];
    }
}
