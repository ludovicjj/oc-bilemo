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
        //TODO check if user ask page = 'hello'
        //TODO check if page exist
        //TODO creat getter for access to private properties
        //TODO add link in response with nbPage, current page, nbItems...

        //TODO Get param 'page' with default value is 1
        $this->currentPage = $request->query->get('page', 1);

        // TODO Get number of phone in DB
        // TODO return string|null
        $this->nbItems = $phoneRepository->countPhone();

        //TODO Defined param first for query setFirstResult()
        $first = $this->currentPage * $this->itemsPerPage - $this->itemsPerPage;

        //TODO Get phones for current page order by date
        //TODO Return array with object Phone
        $this->currentItemsByPage = $phoneRepository->getPhoneByPage($first, $this->itemsPerPage);


        return $this->currentItemsByPage;
    }
}
