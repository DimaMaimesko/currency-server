<?php

namespace App\Repository;

use App\Model\Entities\Email;
use App\Model\Entities\Subscriber;
use App\Model\EntityNotFoundException;
use App\Model\User\Entity\User\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class SubscribersRepository extends ServiceEntityRepository
{

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Subscriber::class);
    }

    /**
     * @return Subscriber[]
     */
    public function findByEmail(Email $email): array
    {
        $email = $email->getValue();
        return $this->createQueryBuilder('s')
                ->andWhere('s.email = :val')
                ->setParameter('val', $email)
                ->orderBy('s.id', 'ASC')
                ->getQuery()
                ->getResult()
            ;
    }

    /**
     * @return Subscriber[]
     */
    public function all(): array
    {
        return $this->createQueryBuilder('s')
            ->orderBy('s.id', 'ASC')
            ->getQuery()
            ->getResult()
            ;
    }

}
