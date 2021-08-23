<?php

namespace Mar4hk0\Models;

class Task
{
    public const STATUS_NEW = 'new';
    public const STATUS_CANCELED = 'canceled';
    public const STATUS_IN_PROGRESS = 'in_progress';
    public const STATUS_PASSED = 'passed';
    public const STATUS_FAILED = 'failed';

    public const ACTION_RESPOND = 'action_respond';
    public const ACTION_REFUSE = 'action_refuse';
    public const ACTION_CANCEL = 'action_cancel';
    public const ACTION_START = 'action_start';
    public const ACTION_FINISH = 'action_finish';

    private string $status = self::STATUS_NEW;

    private int $id;
    private ?int $idSpecialist;
    private int $idCustomer;
    private int $price;

    /**
     * Stores date in UTC Format.
     * @var int
     */
    private int $deadline;
    private string $name;
    private string $description;
    private int $idCategory;
    private bool $remote;

    private ?TaskGeo $taskGeo = null;

    public function __construct(int $idCustomer, ?int $idSpecialist = null)
    {
        $this->idCustomer = $idCustomer;
        $this->idSpecialist = $idSpecialist;
    }

    public function getStatuses():array
    {
        return [
            self::STATUS_NEW => 'Новое',
            self::STATUS_CANCELED => 'Отменено',
            self::STATUS_IN_PROGRESS => 'В работе',
            self::STATUS_PASSED => 'Выполнено',
            self::STATUS_FAILED => 'Провалено',
        ];
    }

    public function getActions():array
    {
        return [
            self::ACTION_RESPOND => 'Откликнуться',
            self::ACTION_REFUSE => 'Отказаться',
            self::ACTION_CANCEL => 'Отменить',
            self::ACTION_START => 'Принять',
            self::ACTION_FINISH => 'Завершить',
        ];
    }

    public function getNextStatus(string $action): ?string
    {
        $status = null;
        if ($this->status == self::STATUS_NEW) {
            if ($action == self::ACTION_RESPOND) {
                $status = self::STATUS_NEW;
            }
            if ($action == self::ACTION_CANCEL) {
                $status = self::STATUS_CANCELED;
            }
            if ($action == self::ACTION_START) {
                $status = self::STATUS_IN_PROGRESS;
            }
        }
        elseif ($this->status == self::STATUS_IN_PROGRESS) {
            if ($action == self::ACTION_FINISH) {
                $status = self::STATUS_PASSED;
            }
            if ($action == self::ACTION_REFUSE) {
                $status = self::STATUS_FAILED;
            }
        }
        return $status;
    }

    public function getActionsByStatus(string $status, int $idCurrentUser): array
    {
        $actions = [];
        $allowedActions = [];
        if ($status == self::STATUS_NEW) {
            $allowedActions = array_merge($allowedActions, [new CancelAction(), new RespondAction()]);
            // Если есть отклики, то еще может быть действие "Старт задания"
            $respond = new Respond();
            if ($respond->hasRespond($this->id)) {
                $allowedActions[] = new StartAction();
            }
        }
        if ($status == self::STATUS_IN_PROGRESS) {
            $allowedActions = array_merge($allowedActions, [new RefuseAction(), new FinishAction()]);
        }

        foreach ($allowedActions as $action) {
            if ($action->checkPermissions($this->idSpecialist, $this->idCustomer, $idCurrentUser)) {
                $actions[] = $action;
            }
        }
        return $actions;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function setStatus(string $status): bool
    {
        if (!isset($this->getStatuses()[$status])) {
            return false;
        }

        $this->status = $status;
        return true;
    }

    public function getStatusHuman(): ?string
    {
        return $this->getStatuses()[$this->status] ?? null;
    }

    public function getPrice(): int
    {
        return $this->price;
    }

    public function setPrice(int $price): void
    {
        $this->price = $price;
    }

    public function getDeadline(): string
    {
        return date('Y-m-d', $this->deadline);
    }

    public function setDeadline(int $deadline): void
    {
        $this->deadline = $deadline;
    }

    public function getName(): string
    {
        return strip_tags($this->name);
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getDescription(): string
    {
        return htmlspecialchars($this->description);
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function getIdCategory(): int
    {
        return $this->idCategory;
    }

    public function setIdCategory(int $idCategory): void
    {
        $this->idCategory = $idCategory;
    }

    public function isRemote(): bool
    {
        return $this->remote;
    }

    public function setRemote(bool $remote): void
    {
        $this->remote = $remote;
    }

    public function getTaskGeo(): ?TaskGeo
    {
        return $this->taskGeo;
    }

    public function setTaskGeo(TaskGeo $taskGeo): void
    {
        $this->taskGeo = $taskGeo;
    }

    public function getIdCustomer(): int
    {
        return $this->idCustomer;
    }

}
