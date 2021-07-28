<?php

namespace App\Transformer\Character;

use App\DTO\Character\CharacterDtoOutput;
use App\Entity\Character;

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
        $out->setName($character->getName())
            ->setStatus($character->getStatus())
            ->setSpecies($character->getSpecies())
            ->setType($character->getType());
        $locations = [
//            'name' => $character->getLocations()
        ];
        $out->setLocation($locations);

        return $out;
    }
}