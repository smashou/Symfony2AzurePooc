<?php

namespace AppBundle\Service;

use Doctrine\ORM\EntityManager;
use AppBundle\Entity\Blog;
use AppBundle\Entity\Post;
use Monolog\Logger;

class PostService
{
    private $em;
    private $logger;

    public function __construct(EntityManager $entityManager, Logger $logger)
    {
        $this->em          = $entityManager;
        $this->logger      = $logger;
    }

    public function findPostsByBlog(Blog $blog)
    {
        if(null === $blog) {
            return null;
        }
        $posts = $this->em->getRepository("AppBundle:Post")->findByBlog($blog);

        return $posts;
    }

    public function findOneById($id)
    {
        if(null === $id) {
            return null;
        }

        $post = $this->em->getRepository("AppBundle:Post")->findOneById($id);

        return $post;

    }

    public function save(Post $post)
    {
        if(null !== $post) {
            $this->em->persist($post);
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

