<?php

namespace app\services;

use app\models\Category;
use app\models\City;
use DateTime;
use Mar4hk0\Helpers\StringHelper;
use yii\helpers\ArrayHelper;

class TaskService
{
    /* @var $tasks array of Task */
    private array $tasks;

    public function __construct(array $tasks)
    {
        $this->tasks = $tasks;
    }

    public function prepareIndex(): array
    {
        $categoryIds = array_map(function ($task) {
            return $task['category_id'];
        }, $this->tasks);
        $skills = ArrayHelper::index(Category::findAll(array_unique($categoryIds)), 'id');
        $cityIds = array_map(function ($task) {
            return $task['city_id'];
        }, $this->tasks);
        $cities = ArrayHelper::index(City::findAll(array_unique($cityIds)), 'id');

        $result = [];
        foreach ($this->tasks as $task) {
            $result[$task['id']] = [
                'task_id' => $task['id'],
                'title' => $task['title'],
                'description' => $task['description'],
                'price' => $task->getPriceHuman(),
                'category_name' => $skills[$task['category_id']]->name,
                'city_name' => $cities[$task['city_id']]->name,
                'relative_time' => $this->convertTimeToRelativeTime($task['created']),
                'created' => $task['created'],
            ];
        }
        return $result;
    }

    private function convertTimeToRelativeTime(string $created): string
    {
        $currentDate = new DateTime();
        $createdDate = new DateTime($created);
        $interval = $currentDate->diff($createdDate);
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


}
