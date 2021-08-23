<?php

require_once __DIR__ . '/vendor/autoload.php';

use Mar4hk0\Models\Task;

// В php.ini установил значения:
// - zend.assertions = 1
// - assert.exception = 1

$idCustomer = 10;
$idSpecialist = 12;
$testTask = new Task($idCustomer);
$testTask->setId(111);

$status = 'Новое';
$i = 1;
assert(
    $testTask->getStatuses()[Task::STATUS_NEW] === $status,
    "Test$i: failed function getStatuses"
);

$action = 'Откликнуться';
$i++;
assert(
    $testTask->getActions()[Task::ACTION_RESPOND] === $action,
    "Test$i: failed function getActions"
);

$i++;
assert(
    $testTask->getNextStatus(Task::ACTION_START) === Task::STATUS_IN_PROGRESS,
    "Test$i: failed function getNextStatus"
);

$i++;
assert(
    $testTask->setStatus(Task::STATUS_NEW) === true,
    "Test$i: failed function setStatus"
);

$i++;
assert(
    $testTask->setStatus('fake_status') === false,
    "Test$i: failed function setStatus"
);

$i++;
$statusHuman = 'Отменено';
$testTask->setStatus(Task::STATUS_CANCELED);
assert(
    $testTask->getStatusHuman() === $statusHuman,
    "Test$i: failed function getStatusHuman"
);

$testTask->setDeadline(time());
$currentDate = date('Y-m-d');
$i++;
assert(
    $testTask->getDeadline() === $currentDate,
    "Test$i: failed function getDeadline"
);

$testTask->setStatus(Task::STATUS_NEW);
$actions = $testTask->getActionsByStatus(Task::STATUS_NEW, $idSpecialist);
$i++;
assert(
    $actions[0] instanceof \Mar4hk0\Models\RespondAction,
    "Test$i: failed, got wrong action"
);

$actions = $testTask->getActionsByStatus(Task::STATUS_NEW, $idCustomer);
$i++;
assert(
    $actions[0] instanceof \Mar4hk0\Models\CancelAction,
    "Test$i: failed, got wrong action"
);
assert(
    $actions[1] instanceof \Mar4hk0\Models\StartAction,
    "Test$i: failed, got wrong action"
);

$testTask->setIdSpecialist(null);
$actions = $testTask->getActionsByStatus(Task::STATUS_IN_PROGRESS, $idCustomer);
$i++;
assert(
    empty($actions),
    "Test$i: failed, got action"
);

$testTask->setIdSpecialist($idSpecialist);
$actions = $testTask->getActionsByStatus(Task::STATUS_IN_PROGRESS, $idCustomer);
$i++;
assert(
    $actions[0] instanceof \Mar4hk0\Models\FinishAction,
    "Test$i: failed, got wrong action"
);

$testTask->setIdSpecialist($idSpecialist);
$actions = $testTask->getActionsByStatus(Task::STATUS_IN_PROGRESS, $idSpecialist);
$i++;
assert(
    $actions[0] instanceof \Mar4hk0\Models\RefuseAction,
    "Test$i: failed, got wrong action"
);

$testTask->setIdSpecialist($idSpecialist);
$actions = $testTask->getActionsByStatus(Task::STATUS_IN_PROGRESS, $idSpecialist);
$i++;
assert(
    !($actions[0] instanceof \Mar4hk0\Models\StartAction),
    "Test$i: failed, got wrong action"
);
echo 'All tests passed' . PHP_EOL;
