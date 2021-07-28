<?php

namespace App\Manager\Character;

use App\Repository\CharacterRepository;

class CharacterManager
{
    /**
     * @var CharacterRepository
     */
    private $repository;

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

    }
}