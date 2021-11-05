<?php

namespace app\models;

use DateTime;

class TaskSearchForm extends Task
{
    public array $filterCategories = [];
    public string $period = '';
    public bool $remoteJob = false;
    public bool $notBids = false;

    public function filterTasks(array $queryParams): array
    {
        // @TODO нужно делать отдельный модель или тут можно это сделать?
        $query = Task::find()->where(['tasks.status_id' => Status::getStatusNewId()]);
        if (!empty($queryParams['filterCategories'])) {
            $query->andWhere(['tasks.category_id' => $queryParams['filterCategories']]);
            $this->filterCategories = $queryParams['filterCategories'];
        }
        if (!empty($queryParams['period'])) {
            $this->period = $queryParams['period'];
            $dateTime = new DateTime('-' . $queryParams['period']);
            $query->andWhere(['>', 'tasks.created', $dateTime->format('Y-m-d H:i:s')]);
        }
        if (!empty($queryParams['notBids'])) {
            $this->notBids = true;
            $query->select(['tasks.*']);
            $query->joinWith('bids');
            $query->andWhere(['bids.id' => null]);
        }
        if (!empty($queryParams['remoteJob'])) {
            $this->remoteJob = true;
            $query->andWhere(['tasks.city_id' => null]);
        }
        return $query->indexBy('id')->all();
    }
}
