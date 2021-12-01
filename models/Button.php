<?php

namespace app\models;

use Mar4hk0\Exceptions\ExceptionTask;

class Button
{
    private Task $task;
    private User $user;

    public function __construct(Task $task, User $user)
    {
        $this->task = $task;
        $this->user = $user;
    }

    public function getAction(): array
    {
        $actions = [];
        $allowedActions = [];
        if ($this->task->status_id == Status::getStatusNewId()) {
            $allowedActions = array_merge($allowedActions, [new CancelAction(), new BidAction()]);
            // Если есть отклики, то еще может быть действие "Старт задания"
            if (!empty($this->task->bids)) {
                $allowedActions[] = new StartAction();
            }
        }
        if ($this->task->status_id == Status::getStatusInProcessId()) {
            $allowedActions = array_merge($allowedActions, [new RefuseAction(), new FinishAction()]);
        }

        if (empty($allowedActions)) {
            throw new ExceptionTask(
                'Could not get Action by status: ' . $this->task->status_id
            );
        }

        foreach ($allowedActions as $action) {
            if ($action->checkPermissions($this->task->performer_id, $this->task->client_id, $this->user)) {
                $actions[] = $action;
            }
        }
        return $actions;
    }
}
