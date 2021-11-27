<?php

namespace app\controllers;

use app\models\Category;
use app\models\City;
use app\models\Task;
use app\models\Status;
use app\models\TaskForm;
use app\models\TaskSearchForm;
use app\services\CategoryService;
use app\services\TaskService;
use Mar4hk0\Exceptions\ExceptionFile;
use Mar4hk0\Exceptions\ExceptionTask;
use Yii;
use yii\db\Exception;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;

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

    public function actionCreate()
    {
        $model = new TaskForm();
        if ($this->request->isPost) {
            try {
                $model->load($this->request->post());
                $model->filesSource = UploadedFile::getInstances($model, 'filesSource');
                if (!$model->process()) {
                    throw new Exception('Something goes wrong!');
                }
                $task = $model->getTask();
                return $this->redirect(['view', 'id' => $task->id]);
            }
            catch (ExceptionTask | ExceptionFile $exception) {
                Yii::$app->session->setFlash('error', $exception->getMessage());
            }
        }

        $categoryService = new CategoryService(Category::getAll());
        $humanCategories = $categoryService->getHumanCategories();

        return $this->render('create', ['model' => $model, 'categories' => $humanCategories]);
    }

}
