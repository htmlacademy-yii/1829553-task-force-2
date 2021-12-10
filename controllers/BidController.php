<?php

namespace app\controllers;

use Exception;
use Yii;
use app\models\Bid;
use yii\helpers\Url;

class BidController extends SecuredController
{
    public function behaviors()
    {
        $rules = parent::behaviors();
        $rule = [
            'allow' => false,
            'actions' => ['create'],
            'matchCallback' => function ($rule, $action) {
                $result = false;

                if (Yii::$app->params['user']->is_client) {
                    return true;
                }
                if ($this->request->isPost) {
                    $bid = new Bid();
                    $bid->load($this->request->post());
                    $existBid = Bid::findOne([
                        'task_id' => $bid->task_id,
                        'performer_id' => $bid->performer_id,
                    ]);
                    if (!empty($existBid)) {
                        return true;
                    }
                }

                return $result;
            }
        ];

        array_unshift($rules['access']['rules'], $rule);

        return $rules;
    }

    public function actionRefuse($id)
    {
        $bid = Bid::findOne($id);
        $bid->refuse();
        if (!$bid->save()) {
            throw new Exception('Something goes wrong!');
        }
        $this->redirect(Yii::$app->request->referrer);
    }

    public function actionCreate()
    {
        if (!$this->request->isPost) {
            $this->goHome();
        }

        $bid = new Bid();
        $bid->load($this->request->post());
        $bid->is_refused = false;
        $bid->created = date('Y-m-d H:i:s');
        if ($bid->validate()) {
            if (!$bid->save()) {
                throw new Exception('Something goes wrong!');
            }
            return $this->redirect(Url::to(['tasks/view', 'id' => $bid->task_id]));
        }
    }
}
