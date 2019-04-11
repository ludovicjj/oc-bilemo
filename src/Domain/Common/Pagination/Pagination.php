<?php

namespace App\Domain\Common\Pagination;

use App\Domain\Repository\AbstractRepository;

class Pagination
{
    /** @var AbstractRepository */
    protected $repository;

    /** @var int */
    protected $currentPage;

    /** @var int */
    protected $itemsPerPage;

    /** @var int */
    protected $nbPages;

    /** @var int */
    protected $nbItems;

    /** @var array|mixed */
    protected $currentItemsByPage;

    /**
     * Pagination constructor.
     * @param AbstractRepository $repository
     * @param int $currentPage
     * @param int $itemsPerPage
     */
    public function __construct(
        AbstractRepository $repository,
        int $currentPage,
        int $itemsPerPage
    ) {
        $this->repository = $repository;
        $this->currentPage = $currentPage;
        $this->itemsPerPage = $itemsPerPage;
    }

    /**
     * @return array|mixed
     */
    public function getCurrentItemsByPage()
    {
        $first = $this->currentPage * $this->itemsPerPage - $this->itemsPerPage;
        $this->currentItemsByPage = $this->repository->getItemsByPage($first, $this->itemsPerPage);
        return $this->currentItemsByPage;
    }

    /**
     * @return int
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function getNbItems()
    {
        $this->nbItems = (int) $this->repository->countItems();
        return $this->nbItems;
    }

    /**
     * @return int
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function getNbPages()
    {
        $this->nbPages = (int) ceil($this->getNbItems()/$this->itemsPerPage);
        return $this->nbPages;
    }
}
