<?php

namespace App\Controller\Character;

use App\DTO\Character\CharacterDtoOutput;
use App\Entity\Character;
use App\Manager\Character\CharacterManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
/**
 * Class CharacterController
 * @Route("/api/character", name="character_")
 */
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
     * @Route("/{id}", name="read", methods={"GET"})
     */
    public function read(Character $character)
    {
        $dto = new CharacterDtoOutput($character);
        return $this->json($dto->serialize());
    }

    /**
     * @Route(name="list", path="/", methods={"GET"})
     */
    public function list (Request $request)
    {
        $params = $request->query->all();
        $baseUrl = $request->getSchemeAndHttpHost() . '/api/character/';
        return $this->json($this->manager->getCharacters($baseUrl, $params));
    }

    /**
     * @Route(name="create", path="", methods={"POST"})
     */
    public function create(Request $request, EntityManagerInterface $em)
    {

        try {
            $character = $this->manager->create(json_decode($request->getContent(), true));
            $em->persist($character);
            $em->flush([$character]);
            return $this->json(['succes' => true, 'character' => (new CharacterDtoOutput($character))->serialize()]);

        } catch (Exception $e) {
            return $this->json(['error' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }
}