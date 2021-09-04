<?php

namespace app\controllers;
use yii\web\Controller;

class ContactsController extends Controller
{
    public function actionIndex()
    {
        \Yii::$app->db->open(); // проверка, что параметры подключения к БД установлены верно
        return $this->render('index');
    }
}