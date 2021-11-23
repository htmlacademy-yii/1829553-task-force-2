<?php

namespace app\controllers;

use Yii;
use app\models\Task;
use app\models\LoginForm;

class LandingController extends \yii\web\Controller
{

    public $layout = 'landing';

    public function beforeAction($action)
    {
        parent::beforeAction($action);
        if (Yii::$app->user->getId()) {
            $this->redirect('/tasks/index');
        }
        return true;
    }

    public function actionIndex()
    {
        $tasks = Task::getLastTasks(4);
        $loginForm = new LoginForm();
        return $this->render('index', ['tasks' => $tasks, 'loginForm' => $loginForm]);
    }

}
