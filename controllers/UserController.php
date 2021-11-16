<?php

namespace app\controllers;

use app\models\Performer;
use yii\web\NotFoundHttpException;

class UserController extends \yii\web\Controller
{
    public function actionView($id)
    {
        $performer = Performer::findOne([$id]);
        if (empty($performer)) {
            throw new NotFoundHttpException();
        }
        return $this->render(
            'view',
            [
                'performer' => $performer,
            ]
        );
    }

}
