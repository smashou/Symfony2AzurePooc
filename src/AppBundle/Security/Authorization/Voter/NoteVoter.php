<?php
/**
 * Created by PhpStorm.
 * User: vincent
 * Date: 21/02/15
 * Time: 17:00
 */

namespace AppBundle\Security\Authorization\Voter;


use Symfony\Component\Security\Core\Authorization\Voter\VoterInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class NoteVoter implements VoterInterface
{
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
        $supportedClass = 'AppBundle\Entity\Note';

        return $supportedClass === $class || is_subclass_of($class, $supportedClass);
    }


    public function vote(TokenInterface $token, $note, array $attributes)
    {

        if (!$this->supportsClass(get_class($note))) {
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
            if(!$note->getPrivate() && $attribute == self::VIEW) {
                return VoterInterface::ACCESS_GRANTED;
            }
            return VoterInterface::ACCESS_DENIED;
        }

        switch($attribute) {
            case self::VIEW:

                if ($user->getId() === $note->getUSer()->getId()) {
                    return VoterInterface::ACCESS_GRANTED;
                }

                if (!$note->getPrivate()) {
                    return VoterInterface::ACCESS_GRANTED;
                }
                break;

            case self::EDIT:

                if ($user->getId() === $note->getUSer()->getId()) {
                    return VoterInterface::ACCESS_GRANTED;
                }
                break;
        }

        return VoterInterface::ACCESS_DENIED;
    }
}