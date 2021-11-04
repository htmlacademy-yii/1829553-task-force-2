<?php

namespace app\controllers;

use app\models\Task;
use app\models\Status;
use app\services\TaskService;
use yii\web\Controller;

class TasksController extends Controller
{
    public function actionIndex()
    {
        $newTasks = Task::getTasks(Status::STATUS_NEW);
        $taskService = new TaskService($newTasks);
        $tasksData = $taskService->prepareIndex();
        return $this->render('index', ['data' => $tasksData]);
    }


}
