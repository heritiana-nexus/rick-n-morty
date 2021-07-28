<?php

namespace App\Entity;

use App\Repository\EpisodeRepository;
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
     * @ORM\Column(type="array", nullable=true)
     */
    private $characters = [];

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

    public function getCharacters(): ?array
    {
        return $this->characters;
    }

    public function setCharacters(?array $characters): self
    {
        $this->characters = $characters;

        return $this;
    }
}
