<?php

namespace app\controllers;

use app\models\Buttons\ButtonCreator;
use app\models\Category;
use app\models\City;
use app\models\RefuseForm;
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
use yii\helpers\Url;
use yii\web\BadRequestHttpException;
use yii\web\JqueryAsset;
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
            ],
            [
                'allow' => false,
                'actions' => ['refuse'],
                'matchCallback' => function ($rule, $action) {
                    $result = false;
                    if (!empty(Yii::$app->params['user']) && $refuseForm = $this->getRefuse() !== null) {
                        $task = Task::findOne($refuseForm->taskId);
                        if (is_null($task)) {
                            return true;
                        }
                        if (Yii::$app->params['user']->id !== $task->performer_id) {
                            $result = true;
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
        $task = Task::findOne($id);
        if (is_null($task)) {
            throw new NotFoundHttpException();
        }

        $buttonCreator = new ButtonCreator($task, Yii::$app->params['user']);
        $button = $buttonCreator->createButton();
        $formButton = $buttonCreator->createForm();
        $renderedForm = null;
        if ($formButton) {
            $renderedForm = $this->renderPartial($formButton->getViewName(), ['model' => $formButton, 'task' => $task]);
        }

        $apiKey = Yii::$app->params['apiGeoKey'];
        $this->view->registerJsFile(
            'https://api-maps.yandex.ru/2.1/?apikey=' . $apiKey . '&lang=ru_RU',
            ['depends' => [JqueryAsset::class]]
        );
        $this->view->registerJsFile(
            '@web/js/render_geo.js',
            ['depends' => [JqueryAsset::class]]
        );
        $this->view->registerJsVar('lat', $task->lat);
        $this->view->registerJsVar('long', $task->long);
        $this->view->registerJsVar('address', $task->address);

        return $this->render(
            'view',
            [
                'task' => $task,
                'button' => $this->renderPartial('button', ['button' => $button]),
                'form' => $renderedForm,
            ]
        );
    }

    public function actionCreate(): string
    {
        $model = new TaskForm();
        if ($this->request->isPost) {
            try {
                $model->load($this->request->post());
                $model->filesSource = UploadedFile::getInstances($model, 'filesSource');
                if (!$model->process()) {
                    throw new BadRequestHttpException();
                }
                $task = $model->getTask();
                $this->redirect(['view', 'id' => $task->id]);
            }
            catch (ExceptionTask | ExceptionFile $exception) {
                Yii::$app->session->setFlash('error', $exception->getMessage());
            }
        }

        $categoryService = new CategoryService(Category::getAll());
        $humanCategories = $categoryService->getHumanCategories();

        return $this->render('create', ['model' => $model, 'categories' => $humanCategories]);
    }

    public function actionAcceptBid(): void
    {
        $this->validateParams();

        $taskId = Yii::$app->request->get(Task::TASK_ID);
        $performerId = Yii::$app->request->get(Task::PERFORMER_ID);

        $task = Task::findOne($taskId);
        if (is_null($task)) {
            throw new BadRequestHttpException();
        }
        $task->acceptBid($performerId);
        if (!$task->save()) {
            throw new BadRequestHttpException();
        }

        $this->redirect(Url::to(['tasks/view', 'id' => $taskId]));
    }

    private function validateParams(): void
    {
        foreach ([Task::TASK_ID, Task::PERFORMER_ID] as $item) {
            if (empty(Yii::$app->request->get($item))) {
                throw new BadRequestHttpException('Something goes wrong!');
            }
        }
    }

    public function actionCancel($id): void
    {
        $task = Task::findOne($id);
        if (is_null($task)) {
            throw new BadRequestHttpException();
        }
        $task->cancel();
        if (!$task->save()) {
            throw new BadRequestHttpException();
        }

        $this->redirect(Url::to(['tasks/view', 'id' => $id]));
    }

    public function actionRefuse(): void
    {
        $refuseForm = $this->getRefuse();
        if (is_null($refuseForm)) {
            $this->goHome();
        }

        $task = Task::findOne($refuseForm->taskId);
        if (is_null($task)) {
            throw new BadRequestHttpException();
        }
        $task->refuse();
        if (!$task->save()) {
            throw new BadRequestHttpException();
        }

        $this->redirect(Url::to(['tasks/view', 'id' => $refuseForm->taskId]));
    }

    private function getRefuse(): ?RefuseForm
    {
        if (!$this->request->isPost) {
            return null;
        }

        $refuseForm = new RefuseForm();
        $refuseForm->load($this->request->post());
        return $refuseForm;
    }
}
