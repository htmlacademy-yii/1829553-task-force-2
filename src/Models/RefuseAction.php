<?php

namespace Mar4hk0\Models;

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

    public function checkPermissions(?int $idSpecialist, int $idCustomer, int $idCurrentUser): bool
    {
        if ($idSpecialist == $idCurrentUser) {
            return true;
        }
        return false;
    }
}
