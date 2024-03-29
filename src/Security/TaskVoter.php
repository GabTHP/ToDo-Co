<?php

namespace   App\Security;

use App\Entity\Task;
use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class TaskVoter extends Voter

{
    // these strings are just invented: you can use anything
    const CAN_DELETE = 'CAN_DELETE';

    protected function supports($attribute, $subject)
    {

        return in_array($attribute, [self::CAN_DELETE]) && $subject instanceof Task;
    }

    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
        $user = $token->getUser();
        // if the user is anonymous, do not grant access
        if (!$user instanceof User) {
            return false;
        }

        /** @var Task $task */
        $task = $subject;

        switch ($attribute) {
            case self::CAN_DELETE:
                return $this->canDelete($task, $user);
        }

        throw new \LogicException('This code should not be reached!');
    }
    private function canDelete(Task $task, User $user)
    {
        $result = true;
        if ($task->getUser()) {
            if ($task->getUser()->getId() !== $user->getId()) {
                $result = false;
            }
        } else {
            if ((in_array("ROLE_ADMIN", $user->getRoles()) === true)) {
                $result = true;
            }
        }


        return $result;
    }
}
