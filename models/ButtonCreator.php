<?php

namespace app\models;

use yii\base\Model;

class ButtonCreator
{
    private Task $task;
    private User $user;
    private Button $button;

    public function __construct(Task $task, User $user)
    {
        $this->task = $task;
        $this->user = $user;
    }

    public function createButton(): ?Button
    {
        $allowedButtons = [];
        if ($this->task->status_id == Status::getStatusNewId()) {
            $allowedButtons = array_merge($allowedButtons, [new CancelButton(), new BidButton()]);
            // Если есть отклики, то еще может быть действие "Старт задания"
            if (!empty($this->task->bids)) {
                $allowedButtons[] = new StartButton();
            }
        }
        if ($this->task->status_id == Status::getStatusInProcessId()) {
            $allowedButtons = array_merge($allowedButtons, [new RefuseButton(), new FinishButton()]);
        }

//        if (empty($allowedButtons)) {
//            throw new ExceptionTask(
//                'Could not get Action by status: ' . $this->task->status_id
//            );
//        }

        foreach ($allowedButtons as $button) {
            if ($button->checkPermissions($this->task->performer_id, $this->task->client_id, $this->user)) {
                $this->button = $button;
                $this->button->setTask($this->task);
                return $this->button;
            }
        }
        return null;
    }

    public function createForm(): ?Model
    {
        return $this->button->createForm();
    }
}
