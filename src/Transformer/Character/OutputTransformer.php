<?php

namespace App\Transformer\Character;

use App\DTO\Character\CharacterDtoOutput;
use App\Entity\Character;
use App\Entity\Episode;

class OutputTransformer
{

    /**
     * OutputTransformer constructor.
     */
    public function __construct()
    {
    }

    public function transformOutput(Character $character): CharacterDtoOutput
    {
        $out = new CharacterDtoOutput();
        $out->setId($character->getId())
            ->setName($character->getName())
            ->setStatus($character->getStatus())
            ->setSpecies($character->getSpecies())
            ->setType($character->getType())
            ->setGender($character->getGender())
            ->setUrl($character->getUrl())
            ->setImage($character->getImage())
            ->setCreated($character->getCreated());
        if ($character->getLocation()) {
            $location = [
                'name' => $character->getLocation()->getName(),
                'url' => $character->getLocation()->getUrl()
            ];
            $out->setLocation($location);
        }
        if ($character->getOrigin()) {
            $origin = [
                'name' => $character->getOrigin()->getName(),
                'url' => $character->getOrigin()->getUrl()
            ];
            $out->setOrigin($origin);
        }
        if ($character->getEpisode()) {
            $episode = array_map(function (Episode $episode) {
                return $episode->getUrl();
            }, $character->getEpisode()->toArray());
            $out->setEpisode($episode);
        }

        return $out;
    }
}