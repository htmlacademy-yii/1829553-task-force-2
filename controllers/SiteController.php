<?php

namespace app\controllers;

use app\models\City;
use app\models\RegistrationForm;
use Yii;
use yii\web\Controller;
use yii\web\Response;

class SiteController extends Controller
{
//    /**
//     * {@inheritdoc}
//     */
//    public function behaviors()
//    {
//        return [
//            'access' => [
//                'class' => AccessControl::className(),
//                'only' => ['logout'],
//                'rules' => [
//                    [
//                        'actions' => ['logout'],
//                        'allow' => true,
//                        'roles' => ['@'],
//                    ],
//                ],
//            ],
//            'verbs' => [
//                'class' => VerbFilter::className(),
//                'actions' => [
//                    'logout' => ['post'],
//                ],
//            ],
//        ];
//    }
//
//    /**
//     * {@inheritdoc}
//     */
//    public function actions()
//    {
//        return [
//            'error' => [
//                'class' => 'yii\web\ErrorAction',
//            ],
//            'captcha' => [
//                'class' => 'yii\captcha\CaptchaAction',
//                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
//            ],
//        ];
//    }
//

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

//    /**
//     * Logout action.
//     *
//     * @return Response
//     */
//    public function actionLogout()
//    {
//        Yii::$app->user->logout();
//
//        return $this->goHome();
//    }


}
