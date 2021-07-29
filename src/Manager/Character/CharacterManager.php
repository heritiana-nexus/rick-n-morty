<?php

namespace App\Manager\Character;

use App\Constant\Pagination;
use App\Entity\Character;
use App\Manager\PaginationService;
use App\Repository\CharacterRepository;
use App\Transformer\Character\OutputTransformer;
use Doctrine\ORM\Tools\Pagination\Paginator;

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

    public function getCharacters()
    {
        $params = [];
        $query = $this->repository->findByParams($params);
        $characters = $this->paginationService->paginate($query, 1, 20);
        $count = $this->paginationService->total($characters);
        $output = [];
        foreach ($characters as $character){
            $output[] = $this->transformer->transformOutput($character);
        }
//        $output = array_map(function (Character $character) {
//            return
//        }, $characters);
        return [
            'info' => [
                'count' => $count,
                'pages' => 1,
                ''
            ],
            'results' => $output
        ];
    }
}