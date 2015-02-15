<?php

namespace AppBundle\Service;

use Doctrine\ORM\EntityManager;
use AppBundle\Entity\Notebook;
use AppBundle\Entity\Note;
use Monolog\Logger;

class NoteService
{
    private $em;
    private $logger;

    public function __construct(EntityManager $entityManager, Logger $logger)
    {
        $this->em          = $entityManager;
        $this->logger      = $logger;
    }

    public function findNotesByNotebook(Notebook $notebook)
    {
        if(null === $notebook) {
            return null;
        }
        $notes = $this->em->getRepository("AppBundle:Note")->findByNotebook($notebook, ['updatedAt' => 'DESC', 'id' => "DESC"]);

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

    public function save(Note $note)
    {
        if(null !== $note) {
            $this->em->persist($note);
            $this->flush();
        }
    }

    private function flush()
    {
        try{
            $this->em->flush();
        } catch ( \Exception $e) {
            $msg = '### Message ### \n'.$e->getMessage().'\n### Trace ### \n'.$e->getTraceAsString();
            $this->logger->critical($msg);
        }
    }

}

