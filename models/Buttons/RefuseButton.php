<?php

namespace app\models\Buttons;

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

    public function checkPermissions(): bool
    {
        if ($this->task->performer_id == $this->user->id && !$this->user->is_client) {
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
