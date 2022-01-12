<?php

namespace app\controllers;

use app\models\Auth;
use app\models\User;
use Exception;
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
                'only' => ['logout', 'login', 'registration', 'auth'],
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
                    [
                        'actions' => ['auth'],
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
            'auth' => [
                'class' => 'yii\authclient\AuthAction',
                'successCallback' => [$this, 'onAuthSuccess'],
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

    public function onAuthSuccess($client)
    {
        $attributes = $client->getUserAttributes();

        $condition = !empty($attributes['user_id']) && !empty($attributes['email'])
            && !empty($attributes['city']) && !empty($attributes['city']['title']);

        if (!$condition) {
            throw new Exception('Something goes wrong!');
        }

        /* @var $auth Auth */
        $auth = Auth::find()->where([
            'vk_user_id' => $attributes['user_id'],
        ])->one();

        if (Yii::$app->user->isGuest) {
            if ($auth) {
                $user = $auth->user;
                Yii::$app->user->login($user);
            } else { // регистрация
                if (isset($attributes['email']) && User::find()->where(['email' => $attributes['email']])->exists()) {
                    throw new Exception(
                        Yii::t(
                            'app',
                            "Пользователь с такой электронной почтой {email} уже существует.",
                            ['email' => $attributes['email']]
                        )
                    );
                } else {
                    $password = Yii::$app->security->generateRandomString(6);
                    $user = new User([
                        'email' => $attributes['email'],
                        'name' => $this->getName($attributes),
                        'password' => $password,
                        'birthday' => !empty($attributes['bdate']) ? date('Y-m-d H:i:s', strtotime($attributes['bdate'])): date('Y-m-d H:i:s'),
                        'is_client' => true,
                        'city_id' => City::getCityIdByName($attributes['city']['title']),
                        'created' => date('Y-m-d H:i:s')
                    ]);
                    $transaction = $user->getDb()->beginTransaction();
                    if ($user->save()) {
                        $auth = new Auth([
                            'user_id' => $user->id,
                            'vk_user_id' => $attributes['user_id'],
                        ]);
                        if ($auth->save()) {
                            $transaction->commit();
                            Yii::$app->user->login($user);
                        } else {
                            throw new Exception('Something goes wrong!');
                        }
                    } else {
                        throw new Exception('Something goes wrong!');
                    }
                }
            }
        }
    }

    private function getName(array $attributes): string
    {
        $result = 'Пользователь из VK';
        if (!empty($attributes['first_name']) && !empty($attributes['last_name'])) {
            $result = $attributes['first_name'] . ' ' . $attributes['last_name'];
        }
        return $result;
    }
}
