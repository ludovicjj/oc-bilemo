<?php

namespace App\Domain\Common\Factory;

use App\Domain\Common\Pagination\Pagination;
use App\Domain\Repository\AbstractRepository;
use App\Domain\Repository\PhoneRepository;
use Symfony\Component\HttpFoundation\Request;

class PaginationFactory
{
    /** @var int */
    protected $itemsPerPage;

    /**
     * PaginationFactory constructor.
     * @param int $itemsPerPage
     */
    public function __construct(
        int $itemsPerPage
    ) {
        $this->itemsPerPage = $itemsPerPage;
    }

    /**
     * @param AbstractRepository $repository
     * @param Request $request
     * @return Pagination
     */
    public function createPagination(
        AbstractRepository $repository,
        Request $request
    ) {
        /** @var int $currentPage */
        $currentPage = (int) $request->query->get('page', 1);

        /** @var Pagination $pagination */
        $pagination = new Pagination(
            $repository,
            $currentPage,
            $this->itemsPerPage
        );

        dump($pagination->getCurrentItemsByPage());
        die;

        return $pagination;
    }
}
