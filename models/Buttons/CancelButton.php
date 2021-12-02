<?php

namespace app\models\Buttons;

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

    public function checkPermissions(): bool
    {
        if (is_null($this->task->performer_id) && $this->task->client_id == $this->user->id && $this->user->is_client) {
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
