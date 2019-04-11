<?php

namespace App\Domain\Common\Factory;

use App\Domain\Repository\PhoneRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class PaginationFactory
{
    /**
     * Define in service.yaml
     * @var int
     */
    protected $itemsPerPage;


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
        //TODO If user ask list phone without param page, page=>1
        //TODO If user ask list phone with page=2, page=>2
        //TODO If user ask list phone with page='hello', page=>0
        /** @var int $currentPage */
        $currentPage = (int) $request->query->get('page', 1);

        //TODO Get number of page
        $nbPage = (int) ceil($phoneRepository->countPhone() / $this->itemsPerPage);

        //TODO Check if page asked by user exist
        //TODO If user ask page > pageExist => error
        //TODO If user ask page < pageExist => error
        if ($currentPage > $nbPage || $currentPage <= 0) {
            throw new NotFoundHttpException(
                sprintf('La page %s n\'existe pas', $request->query->get('page'))
            );
        }
        dump('la page existe');
        die;




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
