<?php

namespace App\Domain\Repository;

use App\Domain\Entity\Phone;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class PhoneRepository extends AbstractRepository
{
    /**
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Phone::class);
    }
     **/

    /**
     * @param string $phoneId
     * @return mixed
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function phoneExist(string $phoneId)
    {
        return $this->createQueryBuilder('p')
            ->where('p.id = :phone_id')
            ->setParameter('phone_id', $phoneId)
            ->getQuery()
            ->getOneOrNullResult();
    }
}
