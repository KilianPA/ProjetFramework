<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

class UserRepository extends EntityRepository
{
    public function TEST($username)
    {
        return $this->createQueryBuilder('m')
            ->select("m.id")
            ->where("m.username = :username")
            ->setParameter('username', $username)
            ->getQuery()
            ->getResult();
    }
}