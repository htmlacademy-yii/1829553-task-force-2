<?php

namespace app\models;

use yii\base\Model;

class StartButton extends Button
{

    private CONST NAME = 'Принять';
    private CONST SYSTEM_NAME = 'action_start';

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
        if (is_null($performerID) && $clientID == $user->id && $user->is_client) {
            return true;
        }
        return false;
    }

    public function getUrl(): string
    {
        // TODO: Implement getUrl() method.
    }

    public function isModal(): bool
    {
        // TODO: Implement isModal() method.
    }

    public function createForm(): ?Model
    {
        // TODO: Implement createForm() method.
    }
}
