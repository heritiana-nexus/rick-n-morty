<?php

namespace App\Manager\Character;

use App\Constant\Pagination;
use App\DTO\Character\CharacterDtoOutput;
use App\Entity\Character;
use App\Entity\Episode;
use App\Entity\Location;
use App\Manager\PaginationService;
use App\Repository\CharacterRepository;
use App\Transformer\Character\OutputTransformer;
use Doctrine\ORM\EntityManagerInterface;

class CharacterManager
{
    const PAGE_LIMIT = 20;
    /**
     * @var CharacterRepository
     */
    private $repository;

    /**
     * @var OutputTransformer
     */
    private $transformer;

    /**
     * @var PaginationService
     */
    private $paginationService;

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * CharacterManager constructor.
     */
    public function __construct(CharacterRepository $repository, OutputTransformer $transformer, PaginationService $paginationService, EntityManagerInterface $entityManager)
    {
        $this->repository = $repository;
        $this->transformer = $transformer;
        $this->paginationService = $paginationService;
        $this->entityManager = $entityManager;
    }

    public function getCharacters(string $baseUrl, array $params): array
    {
        $query = $this->repository->findByParams($params);
        $page = (int)$params['page'] ?? 1;
        $characters = $this->paginationService->paginate($query, $page, self::PAGE_LIMIT);
        $output = [];
        foreach ($characters as $character) {
            $output[] = (new CharacterDtoOutput($character))->serialize();
        }
        return [
            'info' => [
                'count' => $characters->count(),
                'pages' => self::PAGE_LIMIT,
                'next' => $baseUrl . $page + 1,
                'prev' => $baseUrl . $page + 2
            ],
            'results' => $output
        ];
    }

    public function create(array $payload)
    {
        $character = new Character();
        $character->setName($payload['name'] ?? '');
        $character->setStatus($payload['status'] ?? 'unknown');
        $character->setSpecies($payload['species'] ?? '');
        $character->setType($payload['type'] ?? '');
        $character->setGender($payload['gender'] ?? 'unknown');
        $location = $this->entityManager->getRepository(Location::class)->find((int)$payload['location'] ?? -1);
        if ($location) {
            $character->setLocation($location);
        }
        $origin = $this->entityManager->getRepository(Location::class)->find((int)$payload['origin'] ?? -1);
        if ($origin) {
            $character->setOrigin($origin);
        }
        if (!empty($payload['episode'])) {
            foreach ($payload['episode'] as $id) {
                $episode = $this->entityManager->getRepository(Episode::class)->find($id);
                if ($episode) {
                    $character->addEpisode($episode);
                }
            }
        }
        $character->setImage($payload['image'] ?? '');

        return $character;
    }
}