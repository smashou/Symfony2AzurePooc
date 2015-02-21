<?php

namespace AppBundle\Security\Authorization\Voter;


use Symfony\Component\Security\Core\Authorization\Voter\VoterInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class NotebookVoter implements VoterInterface {

    const VIEW = 'view';
    const EDIT = 'edit';

    public function supportsAttribute($attribute)
    {
        return in_array($attribute, array(
            self::VIEW,
            self::EDIT,
        ));
    }

    public function supportsClass($class)
    {
        $supportedClass = 'AppBundle\Entity\Notebook';

        return $supportedClass === $class || is_subclass_of($class, $supportedClass);
    }


    public function vote(TokenInterface $token, $notebook, array $attributes)
    {
        if (!$this->supportsClass(get_class($notebook))) {
            return VoterInterface::ACCESS_ABSTAIN;
        }


        if (1 !== count($attributes)) {
            throw new \InvalidArgumentException(
                'Only one attribute is allowed for VIEW or EDIT'
            );
        }

        $attribute = $attributes[0];

        if (!$this->supportsAttribute($attribute)) {
            return VoterInterface::ACCESS_ABSTAIN;
        }

        $user = $token->getUser();

        if (!$user instanceof UserInterface) {
            return VoterInterface::ACCESS_DENIED;
        }

        switch($attribute) {
            case self::VIEW:

                if ($user->getId() === $notebook->getUSer()->getId()) {
                    return VoterInterface::ACCESS_GRANTED;
                }

                if (!$notebook->getPrivate()) {
                    return VoterInterface::ACCESS_GRANTED;
                }
                break;

            case self::EDIT:

                if ($user->getId() === $notebook->getUSer()->getId()) {
                    return VoterInterface::ACCESS_GRANTED;
                }
                break;
        }

        return VoterInterface::ACCESS_DENIED;
    }
}