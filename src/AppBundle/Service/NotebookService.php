<?php

namespace AppBundle\Service;

use Doctrine\ORM\EntityManager;
use AppBundle\Entity\Notebook;
use Monolog\Logger;

class NotebookService
{
    private $em;
    private $logger;

    public function __construct(EntityManager $entityManager, Logger $logger)
    {
        $this->em          = $entityManager;
        $this->logger      = $logger;
    }

    public function findAll()
    {
        $notebooks = $this->em->getRepository("AppBundle:Notebook")->findBy([], ['updatedAt' => 'ASC']);

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

    public function save(Notebook $notebook)
    {
        if(null !== $notebook) {
            $this->em->persist($notebook);
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

