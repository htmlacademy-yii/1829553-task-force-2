<?php

namespace app\models;

use yii\base\Model;

abstract class Button
{
    private Task $task;

    abstract public function getTitle(): string;
    abstract public function getSystemName(): string;
    abstract public function checkPermissions(?int $performerID, int $clientID, User $user): bool;
    abstract public function getUrl(): string;
    abstract public function isModal(): bool;
    abstract public function createForm(): ?Model;


    public function setTask(Task $task): void
    {
        $this->task = $task;
    }

    public function getTask()
    {
        return $this->task;
    }
}
