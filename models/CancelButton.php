<?php

namespace app\models;

use yii\base\Model;
use yii\helpers\Url;

class CancelButton extends Button
{

    private CONST NAME = 'Отменить';
    private CONST SYSTEM_NAME = 'action_cancel';

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
        $task = $this->getTask();
        return Url::to(['tasks/cancel', 'id' => $task->id]);
    }

    public function isModal(): bool
    {
        return false;
    }

    public function createForm(): ?Model
    {
        return null;
    }
}
