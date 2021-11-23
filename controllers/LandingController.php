<?php

namespace app\controllers;

use app\models\LoginForm;
use app\models\Task;

class LandingController extends \yii\web\Controller
{

    public $layout = 'landing';

    public function actionIndex()
    {
        $tasks = Task::getLastTasks(4);
        $loginForm = new LoginForm();
        return $this->render('index', ['tasks' => $tasks, 'loginForm' => $loginForm]);
    }

    public function actionLogin()
    {
        $loginForm = new LoginForm();
        if (\Yii::$app->request->getIsPost()) {
            $loginForm->load(\Yii::$app->request->post());
            if ($loginForm->validate()) {
                $user = $loginForm->getUser();
                \Yii::$app->user->login($user);
                return $this->redirect('/tasks/index');
            }
        }
    }

    public function actionLogout()
    {
        \Yii::$app->user->logout();
        return $this->goHome();
    }

}
