<?php

namespace app\services;

use app\models\City;
use app\models\Skill;
use DateTime;
use yii\helpers\ArrayHelper;

class TaskService
{
    /* @var $tasks array of Task */
    private array $tasks;

    public function __construct(array $tasks)
    {
        $this->tasks = $tasks;
    }

    public function index(): array
    {
        $skillIds = array_map(function ($task) {
            return $task['id_skill'];
        }, $this->tasks);
        $skills = ArrayHelper::index(Skill::findAll(array_unique($skillIds)), 'id');
        $cityIds = array_map(function ($task) {
            return $task['id_city'];
        }, $this->tasks);
        $cities = ArrayHelper::index(City::findAll(array_unique($cityIds)), 'id');

        $result = [];
        foreach ($this->tasks as $task) {
            $result[$task['id']] = [
                'id' => $task['id'],
                'name' => $task['name'],
                'description' => $task['description'],
                'price' => $task['price'],
                'skill_name' => $skills[$task['id_skill']]->name,
                'skill_icon' => $skills[$task['id_skill']]->icon,
                'city_name' => $cities[$task['id_city']]->name,
                'countdown_time' => $this->convertTimeToCountdownTime($task['created']),
                'created' => $task['created'],
            ];
        }
        return $result;
    }

    private function convertTimeToCountdownTime(string $created): string
    {
        $current = new DateTime();
        $r = new DateTime($created);
        $interval = $current->diff($r);
        // @TODO Adds plural
        if ($year = $interval->format('%y')) {
            return $year . ' год назад';
        }
        if ($month = $interval->format('%m')) {
            return $month . ' месяц назад';
        }
        if ($day = $interval->format('%d')) {
            return $day . ' день назад';
        }
        if ($hour = $interval->format('%h')) {
            return $hour . ' часов назад';
        }
        if ($minute = $interval->format('%i')) {
            return $minute . ' минуту назад';
        }
        return 'только что';

    }


}
