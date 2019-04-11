<?php

namespace App\Domain\Common\Factory;

use App\Domain\Common\Pagination\Pagination;
use App\Domain\Repository\AbstractRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class PaginationFactory
{
    /** @var int */
    protected $itemsPerPage;

    /** @var UrlGeneratorInterface */
    protected $urlGeneratorInterface;

    /** @var string */
    protected $currentRoute;

    protected $links = [];

    /**
     * PaginationFactory constructor.
     * @param int $itemsPerPage
     * @param UrlGeneratorInterface $urlGeneratorInterface
     */
    public function __construct(
        int $itemsPerPage,
        UrlGeneratorInterface $urlGeneratorInterface
    ) {
        $this->itemsPerPage = $itemsPerPage;
        $this->urlGeneratorInterface = $urlGeneratorInterface;
    }

    /**
     * @param Request $request
     * @param AbstractRepository $repository
     * @return Pagination
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function create(
        Request $request,
        AbstractRepository $repository
    ) {
        /** @var string currentRoute */
        $this->currentRoute = $request->attributes->get('_route');

        /** @var int $currentPage */
        $currentPage = (int) $request->query->get('page', 1);

        /** @var Pagination $pagination */
        $pagination = new Pagination(
            $repository,
            $currentPage,
            $this->itemsPerPage
        );

        //TODO Check if catalog of phone is empty
        if ($pagination->getNbItems() === 0) {
            return null;
        }

        //TODO Check if page exist
        //TODO if user ask list phone with currentPage > maxNbPages =>error
        //TODO if user ask list phone with currentPage < 1 =>error
        if ($currentPage > $pagination->getNbPages() || $currentPage <= 0) {
            throw new NotFoundHttpException(
                sprintf('La page %s n\'existe pas', $request->query->get('page'))
            );
        }

        //TODO Create link for current page
        $this->createLink(
            'current',
            $this->urlGeneratorInterface->generate(
                $this->currentRoute,
                ['page' => $pagination->getCurrentPage()],
                0
            )
        );

        //TODO Create link for previous page
        if ($pagination->previousPage()) {
            $this->createLink(
                'previous',
                $this->urlGeneratorInterface->generate(
                    $this->currentRoute,
                    ['page' => $pagination->getCurrentPage() - 1],
                    0
                )
            );
        }

        //TODO Create link for next page
        if ($pagination->nextPage()) {
            $this->createLink(
                'next',
                $this->urlGeneratorInterface->generate(
                    $this->currentRoute,
                    ['page' => $pagination->getCurrentPage() + 1],
                    0
                )
            );
        }
        $pagination->setLinks($this->links);

        return $pagination;
    }

    public function createLink($href, $url)
    {
        return $this->links[$href] = $url;
    }
}
