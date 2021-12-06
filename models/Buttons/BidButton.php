<?php

namespace app\models\Buttons;

use app\models\Bid;
use app\models\Modable;

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

    public function checkPermissions(): bool
    {
        if ($this->task->getBids()->where(['performer_id' => $this->user->id])->exists()) {
            return false;
        }

        if (is_null($this->task->performer_id) && $this->task->client_id != $this->user->id && !$this->user->is_client) {
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

    public function createForm(): ?Modable
    {
        return new Bid();
    }
}
