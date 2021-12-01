<?php

namespace app\controllers;

use app\models\Bid;
use app\models\Task;
use Exception;
use Yii;

class BidController extends SecuredController
{
    public function actionRefuse($bidId)
    {
        $bid = Bid::findOne($bidId);
        $bid->refuse();
        if (!$bid->save()) {
            throw new Exception('Something goes wrong!');
        }
        $this->redirect(Yii::$app->request->referrer);
    }

}
