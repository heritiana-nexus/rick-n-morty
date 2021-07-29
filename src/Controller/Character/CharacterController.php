<?php

namespace App\Controller\Character;

use App\Manager\Character\CharacterManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class CharacterController extends AbstractController
{
    /**
     * @var CharacterManager
     */
    private $manager;

    /**
     * CharacterController constructor.
     */
    public function __construct(CharacterManager $characterManager)
    {
        $this->manager = $characterManager;
    }

    /**
     * @Route(
     *     name="get_character_list",
     *     path="/api/character",
     *     methods={"GET"}
     * )
     */
    public function getCharactersAction(Request $request)
    {
        $response = $this->manager->getCharacters();
        dd($response);
    }

}