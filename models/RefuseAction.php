<?php

namespace app\models;

class RefuseAction extends Action
{

    private CONST NAME = 'Отказаться';
    private CONST SYSTEM_NAME = 'action_refuse';

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
        if ($performerID == $user->id && !$user->is_client) {
            return true;
        }
        return false;
    }
}
