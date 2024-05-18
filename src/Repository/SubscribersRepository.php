<?php

namespace App\Repository;

use App\Model\Entities\Email;
use App\Model\Entities\Subscriber;
use App\Model\EntityNotFoundException;
use App\Model\User\Entity\User\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Config\Definition\Exception\Exception;

class SubscribersRepository
{
    /**
     * @var \Doctrine\ORM\EntityRepository
     */
    private $repo;
    public function __construct(protected EntityManagerInterface $entityManager)
    {
        $this->repo = $this->entityManager->getRepository(Subscriber::class);
    }

    public function findByEmail(Email $email): ?Subscriber
    {
         return $this->repo->findOneBy(['email' => $email->getValue()]);
    }

    public function getByEmail(Email $email): Subscriber
    {
        if (!$subscriber = $this->repo->findOneBy(['email' => $email->getValue()])) {
            throw new Exception('User is not found.');
        }
        return $subscriber;
    }

    public function add(Subscriber $subscriber): void
    {
        $this->entityManager->persist($subscriber);
        $this->entityManager->flush();
    }

    public function all(): array
    {
        return $this->repo->findAll();
    }

}
