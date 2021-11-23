<?php

namespace app\controllers;

use Yii;
use app\models\City;
use app\models\LoginForm;
use app\models\RegistrationForm;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\AccessControl;


class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['logout', 'login', 'registration'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['login'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['registration'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Login action.
     */
    public function actionLogin()
    {
        $loginForm = new LoginForm();
        if (Yii::$app->request->getIsPost()) {
            $loginForm->load(\Yii::$app->request->post());
            if ($loginForm->validate()) {
                $user = $loginForm->getUser();
                Yii::$app->user->login($user);
                return $this->redirect('/tasks/index');
            }
        }

        if (!Yii::$app->user->getId()) {
            $this->goHome();
        }
    }

    /**
     * Registration action.
     *
     * @return Response|string
     */
    public function actionRegistration()
    {
        $registrationForm = new RegistrationForm();

        if ($registrationForm->load(Yii::$app->request->post()) && $registrationForm->validate() && $registrationForm->signup()) {
            return $this->redirect('/tasks/index');
        }

        $cities = City::find()->select(['id', 'name'])->indexBy('id')->asArray()->all();
        $cities = array_combine(
            array_map(function ($item) { return $item['id']; }, $cities),
            array_map(function ($item) { return $item['name']; }, $cities)
        );
        return $this->render('registration', [
            'registration' => $registrationForm,
            'cities' => $cities,
        ]);
    }

    /**
     * Logout action.
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();
        return $this->goHome();
    }

}
