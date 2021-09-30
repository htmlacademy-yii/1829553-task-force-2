<?php

namespace app\controllers;

use app\models\City;
use app\models\Skill;
use app\models\Task;
use yii\helpers\ArrayHelper;
use yii\helpers\StringHelper;
use yii\web\Controller;

class TasksController extends Controller
{
    public function actionIndex()
    {
        $tasks = Task::find()->where(['status' => Task::NEW])
            ->orderBy(['created' => SORT_DESC])
            ->all();
        $skillIds = array_map(function ($task) {
            return $task['id_skill'];
        }, $tasks);
        $skills = ArrayHelper::index(Skill::findAll(array_unique($skillIds)), 'id');
        $cityIds = array_map(function ($task) {
            return $task['id_city'];
        }, $tasks);
        $cities = ArrayHelper::index(City::findAll(array_unique($cityIds)), 'id');

        return $this->render(
            'index',
            ['tasks' => $tasks, 'skills' => $skills, 'cities' => $cities]
        );
    }
}
