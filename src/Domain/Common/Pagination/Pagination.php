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

    /** @var array */
    protected $links;

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
        $this->nbPages = (int) ceil($this->getNbItems() / $this->itemsPerPage);
        return $this->nbPages;
    }

    public function getCurrentPage()
    {
        return $this->currentPage;
    }

    /**
     * @return bool
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function nextPage()
    {
        // 1 < 3 =>true
        // 2 < 3 =>true
        // 3 < 3 =>false
        return $this->currentPage < $this->getNbPages();
    }

    /**
     * @return bool
     */
    public function previousPage()
    {
        // 1 > 1 =>false
        // 2 > 1 =>true
        // 3 > 1 =>true
        return $this->currentPage > 1;
    }

    /**
     * @return array
     */
    public function getLinks()
    {
        return $this->links;
    }

    /**
     * @param array $links
     */
    public function setLinks(array $links)
    {
        $this->links = $links;
    }

}
