<?php

namespace App\DTO\Character;

use App\Entity\Character;
use App\Entity\Episode;

class CharacterDtoOutput
{
    /**
     * @var Character
     */
    private $character;

    public function __construct(Character $character)
    {
        $this->character = $character;
    }


    public function serialize()
    {
        return [
            "id" => $this->character->getId(),
            "name" => $this->character->getName(),
            "status"=> $this->character->getStatus(),
            "species"=> $this->character->getSpecies(),
            "type"=> $this->character->getType(),
            "gender"=> $this->character->getGender(),
            "origin"=> !$this->character->getOrigin() ? [] : [
                "name"=> $this->character->getOrigin()->getName(),
                'url' => $this->character->getOrigin()->getUrl(),
            ],
            "location"=> !$this->character->getLocation() ? [] : [
                'name' => $this->character->getLocation()->getName(),
                'url' => $this->character->getLocation()->getUrl(),
            ],
            "image"=> $this->character->getImage(),
            "episode"=> $this->character->getEpisode(),
            "url"=> $this->character->getUrl(),
            "created" => date_format($this->character->getCreated(), DATE_ISO8601)
        ];
    }


}