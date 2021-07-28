<?php

namespace App\Manager\Character;

use App\Entity\Character;
use App\Repository\CharacterRepository;
use App\Transformer\Character\OutputTransformer;

class CharacterManager
{
    /**
     * @var CharacterRepository
     */
    private $repository;

    /**
     * @var OutputTransformer
     */
    private $transformer;

    /**
     * CharacterManager constructor.
     */
    public function __construct(CharacterRepository $repository)
    {
        $this->repository = $repository;
    }

    public function getCharacters()
    {
        $characters = $this->repository->findAll();
        dd($characters);
        $output = array_map(function (Character $character){
            return $this->transformer->transformOutput($character);
        }, $characters);
    }
}