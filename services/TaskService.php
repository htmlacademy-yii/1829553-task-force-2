<?php

namespace app\services;

use DateTime;
use Exception;
use Mar4hk0\Helpers\DateTimeHelper;
use Mar4hk0\Helpers\StringHelper;

class TaskService
{
    /* @var $tasks array of Task */
    private array $tasks;

    public function __construct(array $tasks)
    {
        $this->tasks = $tasks;
    }

    public function getListTasks($categoryService, $cityService): array
    {
        $result = [];

        foreach ($this->tasks as $task) {
            $result[$task['id']] = [
                'task_id' => $task['id'],
                'title' => $task['title'],
                'description' => $task['description'],
                'price' => $this->getPriceHuman($task['id']),
                'category_human_name' => $categoryService->getHumanName($task['category_id']),
                'city_name' => $cityService->getHumanName($task['city_id']),
                'relative_time' => $this->convertTimeToRelativeTime($task['created']),
                'created' => $task['created'],
            ];
        }
        return $result;
    }

    private function convertTimeToRelativeTime(string $created): string
    {
        $interval = DateTimeHelper::diff(new DateTime($created));
        if ($year = $interval->format('%y')) {
            return StringHelper::getPluralNoun($year, 'год', 'года', 'лет');
        }
        if ($month = $interval->format('%m')) {
            return StringHelper::getPluralNoun($month, 'месяц', 'месяца', 'месяцев');
        }
        if ($day = $interval->format('%d')) {
            return StringHelper::getPluralNoun($day, 'день', 'дня', 'дней');
        }
        if ($hour = $interval->format('%h')) {
            return StringHelper::getPluralNoun($hour, 'час', 'часа', 'часов');
        }
        if ($minute = $interval->format('%i')) {
            return StringHelper::getPluralNoun($minute, 'минута', 'минуты', 'минут');
        }
        return 'только что';
    }

    public function getListPeriods(): array
    {
        return [
            '0' => 'Любой',
            '1 hour' => '1 час',
            '12 hours' => '12 часов',
            '24 hours' => '24 часа',
            '1 week' => '1 неделя',
            '2 weeks' => '2 недели',
            '3 weeks' => '3 недели',
        ];
    }

    public function getPriceHuman(int $taskId): string
    {
        $sign = '₽';
        if (empty($this->tasks[$taskId])) {
            throw new Exception('Такой задачи не существует в списках');
        }
        if (empty($this->tasks[$taskId]->price)) {
            return 'Договорная';
        }
        return $this->tasks[$taskId]->price . ' ' . $sign;
    }

}
