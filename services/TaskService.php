<?php

namespace app\services;

use Mar4hk0\Helpers\DateTimeHelper;
use Mar4hk0\Helpers\Price;

class TaskService
{
    /* @var $tasks array of Task */
    private array $tasks;
    /* @var $tasks array of City */
    private array $cities;
    /* @var $tasks array of Category */
    private array $categories;

    public function __construct(array $tasks)
    {
        $this->tasks = $tasks;
    }

    public function setCities(array $cities)
    {
        $this->cities = $cities;
    }

    public function setCategories(array $categories)
    {
        $this->categories = $categories;
    }

    public function getIndex(): array
    {
        $result = [];

        foreach ($this->tasks as $task) {

            $cityName = null;
            if (!$task->remoteJob) {
                $cityName = $this->cities[$task->city_id]->name;
            }

            $result[$task->id] = [
                'task_id' => $task->id,
                'title' => $task->title,
                'description' => $task->description,
                'price' => Price::getPriceHuman($task->price),
                'category_human_name' => $this->categories[$task->category_id]->getHumanName(),
                'city_name' => $cityName,
                'relative_time' => DateTimeHelper::convertTimeToRelative($task->created),
                'created' => $task->created,
                'remote_job' => $task->getRemoteJobHuman()
            ];
        }
        return $result;
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


}
