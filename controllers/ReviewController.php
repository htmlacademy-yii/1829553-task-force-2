<?php

namespace app\controllers;

use Yii;
use app\models\Review;
use app\models\Task;
use yii\helpers\Url;
use yii\web\BadRequestHttpException;

class ReviewController extends SecuredController
{
    public function behaviors(): array
    {
        $rules = parent::behaviors();
        $rule = [
            'allow' => false,
            'actions' => ['create'],
            'matchCallback' => function ($rule, $action) {
                $result = false;

                $review = $this->getReview();
                if (is_null($review)) {
                    $result = true;
                }

                $task = Task::findOne($review->task_id);
                if ($task === null) {
                    $result = true;
                }

                if (Yii::$app->params['user']->id !== $task->client_id) {
                    $result = true;
                }

                return $result;
            }
        ];

        array_unshift($rules['access']['rules'], $rule);

        return $rules;
    }

    public function actionCreate(): void
    {

        $review = $this->getReview();
        if (is_null($review)) {
            $this->goHome();
        }

        $task = Task::findOne($review->task_id);
        if ($review->validate() && $task !== null) {
            $task->finish();
            if (!$task->save())  {
                throw new BadRequestHttpException();
            }
            if (!$review->save())  {
                throw new BadRequestHttpException();
            }
            $this->redirect(Url::to(['tasks/view', 'id' => $review->task_id]));
        }

        throw new BadRequestHttpException();
    }

    private function getReview(): ?Review
    {
        if (!$this->request->isPost) {
            return null;
        }

        $review = new Review();
        $review->load($this->request->post());
        $review->created = date('Y-m-d H:i:s');
        $review->client_id = Yii::$app->params['user']->id;

        return $review;
    }
}
