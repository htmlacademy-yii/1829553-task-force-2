<?php

namespace app\controllers;

use app\models\Category;
use app\models\City;
use app\models\Task;
use app\models\Status;
use app\models\TaskSearchForm;
use app\services\CategoryService;
use app\services\CityService;
use app\services\TaskService;
use Yii;
use yii\web\Controller;

class TasksController extends Controller
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
        $categories = Category::find()->indexBy('id')->indexBy('id')->all();
        $categoryService = new CategoryService($categories);

        $cityIds = array_map(function ($task) {
            return $task['city_id'];
        }, $newTasks);
        $cities = City::find($cityIds)->indexBy('id')->all();
        $cityService = new CityService($cities);

        $taskService = new TaskService($newTasks);
        $listTasks = $taskService->getListTasks($categoryService, $cityService);
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


}
