<?php

namespace Mar4hk0\Models;

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

    public function checkPermissions(?int $idSpecialist, int $idCustomer, int $idCurrentUser): bool
    {
        if (!is_null($idSpecialist) && $idCustomer == $idCurrentUser) {
            return true;
        }
        return false;
    }
}
