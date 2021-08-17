<?php

require_once __DIR__ . '/vendor/autoload.php';

use Mar4hk0\Models\Task;

// В php.ini установил значения:
// - zend.assertions = 1
// - assert.exception = 1

$idCustomer = 10;
$testTask = new Task($idCustomer);
$status = 'Новое';
assert(
    $testTask->getStatuses()[Task::STATUS_NEW] === $status,
    'Test1: failed function getStatuses'
);

$action = 'Откликнуться';
assert(
    $testTask->getActions()[Task::ACTION_RESPOND] === $action,
    'Test2: failed function getActions'
);

assert(
    $testTask->getNextStatus(Task::ACTION_START) === Task::STATUS_IN_PROGRESS,
    'Test3: failed function getNextStatus'
);

assert(
    $testTask->getActionsByStatus(Task::STATUS_NEW, $idCustomer) === [Task::ACTION_CANCEL, Task::ACTION_START],
    'Test4: failed function getActionsByStatus'
);

assert(
    $testTask->setStatus(Task::STATUS_NEW) === true,
    'Test5: failed function setStatus'
);

assert(
    $testTask->setStatus('fake_status') === false,
    'Test6: failed function setStatus'
);

$statusHuman = 'Отменено';
$testTask->setStatus(Task::STATUS_CANCELED);
assert(
    $testTask->getStatusHuman() === $statusHuman,
    'Test7: failed function getStatusHuman'
);


$testTask->setDeadline(time());
$currentDate = date('Y-m-d');
assert(
    $testTask->getDeadline() === $currentDate,
    'Test8: failed function getDeadline'
);

echo 'All tests passed' . PHP_EOL;
