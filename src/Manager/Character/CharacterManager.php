<?php

namespace App\Manager\Character;

use App\Constant\Pagination;
use App\DTO\Character\CharacterDtoOutput;
use App\Entity\Character;
use App\Manager\PaginationService;
use App\Repository\CharacterRepository;
use App\Transformer\Character\OutputTransformer;

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
     * CharacterManager constructor.
     */
    public function __construct(CharacterRepository $repository, OutputTransformer $transformer, PaginationService $paginationService)
    {
        $this->repository = $repository;
        $this->transformer = $transformer;
        $this->paginationService = $paginationService;
    }

    public function getCharacters(string $baseUrl, array $params): array
    {
        $query = $this->repository->findByParams($params);
        $page = (int) $params['page'] ?? 1;
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
        $character->setOrigin($payload['origin'] ?? null);
        $character->setLocation($payload['location'] ?? null);
        $character->setImage($payload['image'] ?? '');

        return $character;
    }
}