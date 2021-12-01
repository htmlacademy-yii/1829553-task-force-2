<?php

namespace app\controllers;

use app\models\Category;
use app\models\City;
use app\models\Client;
use app\models\Performer;
use app\models\Task;
use app\models\Status;
use app\models\TaskForm;
use app\models\TaskSearchForm;
use app\models\User;
use app\services\CategoryService;
use app\services\TaskService;
use Mar4hk0\Exceptions\ExceptionFile;
use Mar4hk0\Exceptions\ExceptionTask;
use Yii;
use yii\db\Exception;
use yii\helpers\Url;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;

class TasksController extends SecuredController
{
    public function behaviors()
    {
        $rules = parent::behaviors();
        $taskRules = [
            [
                'allow' => false,
                'actions' => ['create'],
                'matchCallback' => function ($rule, $action) {
                    $result = false;
                    if (!empty(Yii::$app->params['user'])) {
                        $user = Yii::$app->params['user'];
                        $result = !(bool)$user->is_client;
                    }
                    return $result;
                }
            ],
            [
                'allow' => false,
                'actions' => ['accept-bid'],
                'matchCallback' => function ($rule, $action) {
                    $result = true;
                    if (!empty(Yii::$app->params['user'])) {
                        $this->validateParams();
                        $task = Task::findOne(Yii::$app->request->get(Task::TASK_ID));
                        $user = User::findOne(Yii::$app->request->get(Task::PERFORMER_ID));
                        if ($task->client_id == Yii::$app->params['user']->id && !$user->is_client) {
                            $result = false;
                        }
                    }

                    return $result;
                }
            ]
        ];

        array_unshift($rules['access']['rules'], $taskRules[0], $taskRules[1]);

        return $rules;
    }

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

    public function actionAcceptBid()
    {
        $this->validateParams();

        $taskId = Yii::$app->request->get(Task::TASK_ID);
        $performerId = Yii::$app->request->get(Task::PERFORMER_ID);

        $task = Task::findOne($taskId);
        $task->acceptBid($performerId);
        if (!$task->save()) {
            throw new Exception('Something goes wrong!');
        }

        $this->redirect(Url::to(['tasks/view', 'id' => $taskId]));
    }

    private function validateParams(): void
    {
        foreach ([Task::TASK_ID, Task::PERFORMER_ID] as $item) {
            if (empty(Yii::$app->request->get($item))) {
                throw new Exception('Something goes wrong!');
            }
        }
    }

}
