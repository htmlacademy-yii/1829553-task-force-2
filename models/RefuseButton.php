<?php

namespace app\models;

use yii\base\Model;

class RefuseButton extends Button
{

    private CONST NAME = 'Отказаться';
    private CONST SYSTEM_NAME = 'action_refuse';

    public function getTitle(): string
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

    public function getUrl(): string
    {
        return '#';
    }

    public function isModal(): bool
    {
        return true;
    }

    public function createForm(): ?Model
    {
        // TODO: Implement createForm() method.
    }
}
