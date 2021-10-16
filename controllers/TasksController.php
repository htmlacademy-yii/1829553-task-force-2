<?php

namespace app\controllers;

use app\models\Task;
use app\services\TaskService;
use yii\web\Controller;

class TasksController extends Controller
{
    public function actionIndex()
    {
        $tasks = Task::find()->where(['status' => Task::NEW])
            ->orderBy(['created' => SORT_DESC])
            ->all();
        $taskService = new TaskService($tasks);
        $tasksIndex = $taskService->index();

        return $this->render('index', ['tasks' => $tasksIndex]);
    }
}
