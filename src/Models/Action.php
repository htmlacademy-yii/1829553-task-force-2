<?php

namespace Mar4hk0\Models;

abstract class Action
{
    abstract public function getName(): string;
    abstract public function getSystemName(): string;
    abstract public function checkPermissions(?int $idSpecialist, int $idCustomer, int $idCurrentUser): bool;
}
