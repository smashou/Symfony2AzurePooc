<?php

namespace AppBundle\Service;

use Doctrine\ORM\EntityManager;
use AppBundle\Entity\Blog;
use Monolog\Logger;
use AppBundle\Service\PostService;

class BlogService
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
        $blogs = $this->em->getRepository("AppBundle:Blog")->findAll();

        return $blogs;
    }

    public function findOneById($id)
    {
        if(null === $id) {
            return null;
        }
        $blog = $this->em->getRepository("AppBundle:Blog")->findOneById($id);

        return $blog;
    }

    public function save(Blog $blog)
    {
        if(null !== $blog) {
            $this->em->persist($blog);
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

