<?php

namespace App\Security;

use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Security;

class UserVoter extends Voter
{

    const READ = 'read';
    const UPDATE = 'update';
    const DELETE = 'delete';
    const LIST = 'list';

    private Security $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    private function getOperations(): array
    {
        return [self::READ, self::UPDATE, self::DELETE];
    }

    protected function supports(string $attribute, mixed $subject): bool
    {
        if(!in_array($attribute, $this->getOperations())){
            return false;
        }

        if(!$subject instanceof User){
            return false;
        }

        return true;
    }

    protected function voteOnAttribute(string $attribute, $subject, TokenInterface $token): bool
    {
        // TODO: Implement voteOnAttribute() method.
        $connectedUser = $token->getUser();

        if (!$connectedUser instanceof User){
            //The user must be logged In
            return false;
        }

        $user = $subject;

        switch ($attribute){
            case self::READ:
                return $this->canRead($user, $connectedUser);
            case self::UPDATE:
                return $this->canUpdate($user, $connectedUser);
            case self::DELETE:
                return $this->canDelete();
            case self::LIST:
                return $this->canList();
        }

        throw new \LogicException('This code should not be reached');
    }

    private function canRead(User $user, User $connectedUser): bool
    {
        return $this->security->isGranted('ROLE_ADMIN') || $this->isSameUser($user, $connectedUser);
    }

    private function canUpdate(User $user, User $connectedUser): bool
    {
        return $this->isSameUser($user, $connectedUser);
    }

    private function canDelete(): bool
    {
        //Only super admin can delete an entity
        return $this->security->isGranted('ROLE_SUPER_ADMIN');
    }

    public function canList(): bool
    {
        return $this->security->isGranted('ROLE_ADMIN');
    }

    private function isSameUser(User $user, User $connectedUser) : bool
    {
        return $user === $connectedUser;
    }
}