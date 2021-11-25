<?php

namespace app\controllers;

use app\models\Category;
use app\models\City;
use app\models\Task;
use app\models\Status;
use app\models\TaskSearchForm;
use app\services\TaskService;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class TasksController extends SecuredController
{
    public function actionIndex()
    {
        $taskSearchForm = new TaskSearchForm();

        $request = Yii::$app->request;
        if ($request->isGet && !empty($request->queryParams['TaskSearchForm'])) {
            $newTasks = $taskSearchForm->filterTasks($request->queryParams['TaskSearchForm']);
        }
        else {
            $newTasks = Task::getTasks(Status::STATUS_NEW);
        }
        $categories = Category::getAll();

        $cityIds = array_map(function (Task $task) {
            return $task->city_id;
        }, $newTasks);
        $cities = City::getBatch($cityIds);

        $taskService = new TaskService($newTasks);
        $taskService->setCities($cities);
        $taskService->setCategories($categories);
        $listTasks = $taskService->getIndex();
        $listPeriods = $taskService->getListPeriods();

        return $this->render(
            'index',
            [
                'listTasks' => $listTasks,
                'categories' => $categories,
                'taskSearchForm' => $taskSearchForm,
                'listPeriods' => $listPeriods,
            ]
        );
    }

    public function actionView($id)
    {
        $task = Task::findOne([$id]);
        if (empty($task)) {
            throw new NotFoundHttpException();
        }

        return $this->render(
            'view',
            [
                'task' => $task,
            ]
        );
    }

}
