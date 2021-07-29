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
        $out = new CharacterDtoOutput($character);


        return $out;
    }
}