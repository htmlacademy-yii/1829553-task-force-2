<?php

namespace app\models;

use yii\base\Model;

class BidButton extends Button
{

    private CONST NAME = 'Откликнуться';
    private CONST SYSTEM_NAME = 'action_respond';

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
        if (is_null($performerID) && $clientID != $user->id && !$user->is_client) {
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
        return new BidForm();
    }
}
