<?php

namespace app\controllers;
use app\models\Notification;
use app\models\Skill;
use yii\web\Controller;

class MainController extends Controller
{
    public function actionIndex()
    {
//        $skill = Skill::findOne(4);
////        var_dump($skill);
//        $specialists = $skill->specialists;
//        var_dump($specialists);
//        $notification = Notification::findOne(3);
//        var_dump($notification);
//        $user = $notification->user;
        $notification = new Notification();
        $props = [
            'id_user' => 62,
            'new_message' => 1,
            'actions_task' => 1,
            'new_reviews' => 1,
        ];
        $notification->attributes = $props;
        $notification->save();
        var_dump($notification);
    }
}
