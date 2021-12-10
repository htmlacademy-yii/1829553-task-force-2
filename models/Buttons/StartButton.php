<?php

namespace app\models\Buttons;

use app\models\Modable;

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

    public function checkPermissions(): bool
    {
        if (is_null($this->task->performer_id) && $this->task->client_id == $this->user->id && $this->user->is_client) {
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

    public function createForm(): ?Modable
    {
        return null;
    }
}
