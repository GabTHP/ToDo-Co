<?php

namespace   AppBundle\Security;

use AppBundle\Entity\Task;
use AppBundle\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Security;

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
        if ($task->getUser()->getId() !== $user->getId()) {
            $result = false;
        }

        if ((in_array("ROLE_ADMIN", $user->getRoles()) === true) && ($task->getUser()->getUsername() === "anonymous")) {
            $result = true;
        }

        return $result;
    }
}
