<?php
/**
 * Created by PhpStorm.
 * User: vincent
 * Date: 21/02/15
 * Time: 17:47
 */

namespace AppBundle\Repository;

use Doctrine\ORM\AbstractQuery;
use Doctrine\ORM\EntityRepository;
use UserBundle\Entity\User;

class NoteRepository extends EntityRepository {

    public function findLastNotes(User $user)
    {
        $qb = $this->createQueryBuilder("n")
            ->leftJoin("n.user", "u")
            ->Where("u.id = :user_id")
            ->setParameter("user_id", $user->getId())
            ->orWhere("n.private = :private")
            ->setParameter("private", false);

        return $qb->getQuery()->getResult();
    }
}