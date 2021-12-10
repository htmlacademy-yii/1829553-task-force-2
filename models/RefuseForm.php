<?php

namespace app\models;

use yii\base\Model;

class RefuseForm  extends Model implements Modable
{

    public ?int $taskId = null;

    public function rules()
    {
        return [
            [['taskId'], 'required'],
            ['taskId', 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'taskId' => 'ID',
        ];
    }

    public function getViewName(): string
    {
        return '//tasks/_form_refuse';
    }
}
