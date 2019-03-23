<?php

namespace App\Domain\Security;

use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

class ClientVoter extends Voter
{
    protected function supports($attribute, $object)
    {
        /**
         * L'un des votants par défaut gère tout ce qui commence par ROLE_
         * Créer un nouveau votant qui décide de l'accès chaque fois que nous passons CLIENT_ADD à isGranted().
         */
        if ($attribute != 'CLIENT_CHECK') {
            return false;
        }

        return true;
    }

    protected function voteOnAttribute($attribute, $object, TokenInterface $token)
    {
        $currentClientId = is_object($token->getUser()) ? $token->getUser()->getId() : null;

        if ($object !== $currentClientId) {
            return false;
        }

        return true;
    }
}
