<?php

namespace AppBundle\Service;

use Doctrine\ORM\EntityManager;
use Monolog\Logger;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;


class CoreEntityService
{
    protected $em;
    protected $logger;
    protected $security;
    protected $user;

    public function __construct(EntityManager $entityManager, Logger $logger, SecurityContext $security, TokenStorage $tokenStorage)
    {
        $this->em          = $entityManager;
        $this->logger      = $logger;
        $this->security    = $security;

        if($this->isAuthenticated())
            $this->user = $tokenStorage->getToken()->getUser();
        else
            $this->user = null;
    }


    public function save($object)
    {
        if(null !== $object) {
            $this->em->persist($object);
            $this->flush();
        }
    }

    protected function flush()
    {
        try{
            $this->em->flush();
        } catch ( \Exception $e) {
            $msg = '### Message ### \n'.$e->getMessage().'\n### Trace ### \n'.$e->getTraceAsString();
            $this->logger->critical($msg);
        }
    }

    protected function isAuthenticated()
    {
        if($this->security->isGranted("ROLE_USER")){
            return true;
        }else{
            return false;
        }
    }


}

