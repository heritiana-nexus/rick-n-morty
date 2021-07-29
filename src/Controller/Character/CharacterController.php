<?php

namespace App\Controller\Character;

use App\DTO\Character\CharacterDtoOutput;
use App\Entity\Character;
use App\Manager\Character\CharacterManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
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
    public function read(Character $character, Request $request)
    {
        $baseUrl = $request->getSchemeAndHttpHost() . '/api/character/';
        $dto = new CharacterDtoOutput($character, $baseUrl);
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
            $character = $this->manager->save(json_decode($request->getContent(), true));
            $em->persist($character);
            $em->flush([$character]);
            return $this->json([
                'success' => true,
                'character' => (new CharacterDtoOutput($character, $request))->serialize(),
                ], Response::HTTP_CREATED
            );

        } catch (\Exception $e) {
            return $this->json(['success' => false, 'error' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * @Route(name="update", path="/{id}", methods={"PUT"})
     * @param Character $character
     * @param Request $request
     * @param EntityManagerInterface $em
     * @return JsonResponse
     */
    public function update(Character $character, Request $request, EntityManagerInterface $em)
    {
        try {

            $character = $this->manager->save(json_decode($request->getContent(), true), $character);
            $em->flush([$character]);
            return $this->json([
                'success' => true,
                'character' => (new CharacterDtoOutput($character, $request))->serialize(),
            ], Response::HTTP_OK
            );

        } catch (\Exception $e) {
            return $this->json(['success' => false, 'error' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
}
}