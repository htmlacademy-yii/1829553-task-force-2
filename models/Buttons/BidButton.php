<?php

namespace app\models\Buttons;

use app\models\Bid;
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

    public function checkPermissions(): bool
    {
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

    public function createForm(): ?Model
    {
        return new Bid();
    }
}
