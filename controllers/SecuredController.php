<?php

namespace app\controllers;

use app\models\User;
use Yii;
use yii\filters\AccessControl;

abstract class SecuredController extends \yii\web\Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@']
                    ]
                ]
            ]
        ];
    }

    public function init()
    {
        parent::init();
        if ($id = Yii::$app->user->getId()) {
            Yii::$app->params['user'] = User::findOne($id);
        }
    }

}
