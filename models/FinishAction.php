<?php

namespace app\models;

class FinishAction extends Action
{
    private CONST NAME = 'Завершить';
    private CONST SYSTEM_NAME = 'action_finish';

    public function getName(): string
    {
        return self::NAME;
    }

    public function getSystemName(): string
    {
        return self::SYSTEM_NAME;
    }

    public function checkPermissions(?int $performerID, int $clientID, User $user): bool
    {
        if (!is_null($performerID) && $clientID == $user->id && $user->is_client) {
            return true;
        }
        return false;
    }
}
