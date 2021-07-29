<?php

namespace App\Entity;

use App\Repository\EpisodeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EpisodeRepository::class)
 */
class Episode
{
    use BaseEntityTrait;
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $airDate;

    /**
     * @ORM\Column(type="string", length=20)
     */
    private $episode;

    /**
     * @ORM\ManyToMany(targetEntity=Character::class, mappedBy="episode")
     */
    private $character;

    public function __construct()
    {
        $this->character = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAirDate(): ?string
    {
        return $this->airDate;
    }

    public function setAirDate(string $airDate): self
    {
        $this->airDate = $airDate;

        return $this;
    }

    public function getEpisode(): ?string
    {
        return $this->episode;
    }

    public function setEpisode(string $episode): self
    {
        $this->episode = $episode;

        return $this;
    }

    /**
     * @return Collection|Character[]
     */
    public function getCharacter(): Collection
    {
        return $this->character;
    }

    public function addCharacter(Character $character): self
    {
        if (!$this->character->contains($character)) {
            $this->character[] = $character;
            $character->addEpisode($this);
        }

        return $this;
    }

    public function removeCharacter(Character $character): self
    {
        if ($this->character->removeElement($character)) {
            $character->removeEpisode($this);
        }

        return $this;
    }
}
