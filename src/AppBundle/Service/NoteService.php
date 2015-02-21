<?php

namespace AppBundle\Service;

use Doctrine\ORM\EntityManager;
use AppBundle\Entity\Notebook;
use AppBundle\Entity\Note;
use Monolog\Logger;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;
use AppBundle\Service\CoreEntityService;

class NoteService extends CoreEntityService
{


    public function __construct(EntityManager $entityManager, Logger $logger, SecurityContext $security, TokenStorage $tokenStorage)
    {
        parent::__construct($entityManager, $logger, $security, $tokenStorage);
    }

    public function findNotesByNotebook(Notebook $notebook)
    {
        if(null === $notebook) {
            return null;
        }
        $notes = $this->em->getRepository("AppBundle:Note")->findByNotebook($notebook, ['updatedAt' => 'DESC', 'id' => "DESC"]);

        return $notes;
    }

    public function findLasts()
    {
        if(null !== $this->user) {
            $notes = $this->em->getRepository("AppBundle:Note")->findLastNotes($this->user);
        } else {
            $notes = $this->em->getRepository("AppBundle:Note")->findBy(["private" => false], ['updatedAt' => "DESC"]);
        }


        return $notes;
    }

    public function findOneById($id)
    {
        if(null === $id) {
            return null;
        }

        $note = $this->em->getRepository("AppBundle:Note")->findOneById($id);

        return $note;

    }


}

