<?php

/**
 * Created by PhpStorm.
 * User: harilala
 * Date: 4/29/20
 * Time: 6:34 PM.
 */

namespace App\Manager;

use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\Tools\Pagination\Paginator;

/**
 * Class PaginationService.
 */
class PaginationService
{
    /**
     * @param $query
     * @param int $skip
     */
    public function paginate(
        $query,
        int $page = 20,
        int $limit = null
    ): Paginator {
        $paginator = new Paginator($query);

        if (!empty($limit) && 0 != $limit) {
            $firstResult = ($page - 1) * $limit;
            $paginator
                ->getQuery()
                ->setFirstResult($firstResult)
                ->setMaxResults($limit);
        }

        return $paginator;
    }

    public function total(Paginator $paginator): int
    {
        return $paginator->count();
    }

    /**
     * @param QueryBuilder $query
     * @param int $page
     * @param int|null $limit
     * @return array
     */
    public function paginateScalarResult(
        QueryBuilder $query,
        int $page = Pagination::PAGE_DEFAULT,
        int $limit = null
    ): array {
        if (!empty($limit) && 0 != $limit) {
            $firstResult = ($page - 1) * $limit;
            $query
                ->setFirstResult($firstResult)
                ->setMaxResults($limit);
        }

        return $query->getQuery()->getResult();
    }
}
