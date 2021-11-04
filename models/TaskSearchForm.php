<?php

namespace app\models;

use DateTime;

class TaskSearchForm extends Task
{
    public array $filterCategories = [];
    public string $period = '';

    public function filterTasks(array $queryParams): array
    {

        $query = Task::find()->where(['status_id' => Status::getStatusNewId()]);
        if (!empty($queryParams['filterCategories'])) {
            $query->andWhere(['category_id' => $queryParams['filterCategories']]);
            $this->filterCategories = $queryParams['filterCategories'];
        }
        if (!empty($queryParams['period'])) {
            $this->period = $queryParams['period'];
            $dateTime = new DateTime('-' . $queryParams['period']);
            $query->andWhere(['>', 'created', $dateTime->format('Y-m-d H:i:s')]);
        }
        return $query->all();
    }
}
