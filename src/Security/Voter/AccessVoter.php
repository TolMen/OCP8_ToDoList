<?php

namespace App\Security;

use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class AccessVoter extends Voter
{
    const ALL_USER = 'allUser';
    const MANAGE = 'manage';

    protected function supports(string $attribute, mixed $subject): bool
    {
        // On ne vote que pour les actions ALL_USER et MANAGE
        return in_array($attribute, [self::ALL_USER, self::MANAGE]);
    }

    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();

        if (!$user instanceof User) {
            return false;
        }

        switch ($attribute) {
            case self::ALL_USER:
                $result = in_array('ROLE_USER', $user->getRoles()) || in_array('ROLE_ADMIN', $user->getRoles());
                return $result;

            case self::MANAGE:
                $result = in_array('ROLE_ADMIN', $user->getRoles());
                return $result;
        }

        return false;
    }

}
