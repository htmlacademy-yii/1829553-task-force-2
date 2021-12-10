<?php

namespace app\models\Buttons;

use app\models\Modable;
use app\models\Task;
use app\models\User;
use yii\base\Model;

abstract class Button
{
    protected Task $task;
    protected User $user;

    abstract public function getTitle(): string;
    abstract public function getSystemName(): string;
    abstract public function checkPermissions(): bool;
    abstract public function getUrl(): string;
    abstract public function isModal(): bool;
    abstract public function createForm(): ?Modable;

    public function setTask(Task $task): void
    {
        $this->task = $task;
    }

    public function getTask(): Task
    {
        return $this->task;
    }

    public function setUser(User $user): void
    {
        $this->user = $user;
    }

    public function getUser(): User
    {
        return $this->user;
    }

}
