<?php

namespace App\Domain\Common\Factory;

use App\Domain\Repository\PhoneRepository;
use Symfony\Component\HttpFoundation\Request;

class PaginationFactory
{
    /**
     * Define in service.yaml
     * @var int
     */
    protected $itemsPerPage;

    /**
     * @var int
     */
    protected $currentPage;

    /**
     * @var string|null
     */
    protected $nbItems;

    /**
     * @var array
     */
    protected $currentItemsByPage;

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
     * @param PhoneRepository $phoneRepository
     * @param Request $request
     * @return mixed
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function createPagination(
        PhoneRepository $phoneRepository,
        Request $request
    ) {
        //Get param 'page' with default value is 1
        $this->currentPage = $request->query->get('page', 1);

        //Get number of phone in DB
        //return string|null
        $this->nbItems = $phoneRepository->countPhone();

        //Defined param first for query setFirstResult()
        $first = $this->currentPage * $this->itemsPerPage - $this->itemsPerPage;

        //Get phones for current page order by date
        //Return array with object Phone
        $this->currentItemsByPage = $phoneRepository->getPhoneByPage($first, $this->itemsPerPage);


        return $this->currentItemsByPage;
    }
}
