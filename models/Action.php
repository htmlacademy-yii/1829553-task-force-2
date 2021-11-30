<?php

namespace app\models;

abstract class Action
{
    abstract public function getName(): string;
    abstract public function getSystemName(): string;
    abstract public function checkPermissions(?int $performerID, int $clientID, User $user): bool;
}
