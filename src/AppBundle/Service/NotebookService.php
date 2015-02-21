<?php

namespace AppBundle\Service;

use Doctrine\ORM\EntityManager;
use AppBundle\Entity\Notebook;
use Monolog\Logger;
use UserBundle\Entity\User;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;
use AppBundle\Service\CoreEntityService;

class NotebookService extends CoreEntityService
{
    public function __construct(EntityManager $entityManager, Logger $logger, SecurityContext $security, TokenStorage $tokenStorage)
    {
        parent::__construct($entityManager, $logger, $security, $tokenStorage);
    }

    /**
     * @return \AppBundle\Entity\Notebook[]|array
     */
    public function findAll()
    {
        $notebooks = $this->em->getRepository("AppBundle:Notebook")->findBy(["user" => $this->user], ['updatedAt' => 'ASC']);

        return $notebooks;
    }

    public function findPublic()
    {
        $notebooks = $this->em->getRepository("AppBundle:Notebook")->findBy(["private" => false], ['updatedAt' => 'ASC']);

        return $notebooks;
    }

    public function findByUser(User $user)
    {
        if(null === $user) {
            return null;
        }

        $notebooks = $this->em->getRepository("AppBundle:Notebook")->findBy(["user" => $user], ['updatedAt' => 'ASC']);

        return $notebooks;
    }

    public function findPrivateByUser(User $user)
    {
        if(null === $user) {
            return null;
        }

        $notebooks = $this->em->getRepository("AppBundle:Notebook")->findBy(["user" => $user, "private" => true], ['updatedAt' => 'ASC']);

        return $notebooks;
    }

    public function findOneById($id)
    {
        if(null === $id) {
            return null;
        }
        $notebook = $this->em->getRepository("AppBundle:Notebook")->findOneById($id);

        return $notebook;
    }


}

