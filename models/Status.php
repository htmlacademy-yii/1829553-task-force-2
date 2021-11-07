<?php

namespace app\models;

use Yii;
use yii\base\Exception;

/**
 * This is the model class for table "statuses".
 *
 * @property int $id
 * @property string $system_name
 * @property string $human_name
 *
 * @property Task[] $tasks
 */
class Status extends \yii\db\ActiveRecord
{
    public const STATUS_NEW = 'new';
    public const STATUS_CANCELED = 'canceled';
    public const STATUS_IN_PROCESS = 'in_process';
    public const STATUS_COMPLETED = 'completed';
    public const STATUS_FAILED = 'failed';

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'statuses';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['system_name', 'human_name'], 'required'],
            [['system_name', 'human_name'], 'string', 'max' => 100],
            [['system_name'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'system_name' => 'System Name',
            'human_name' => 'Human Name',
        ];
    }

    /**
     * Gets query for [[Tasks]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTasks()
    {
        return $this->hasMany(Task::className(), ['status_id' => 'id']);
    }

    public static function getStatusId(string $systemName): int
    {
        $status = self::findOne(['system_name' => $systemName]);
        if (is_null($status)) {
            // @todo нужно ли сделать Exception для этого случая
            throw new Exception('Status does not exist for system_name "' . $systemName . '"');
        }
        return $status['id'];
    }

    public static function getStatusNewId(): int
    {
        return static::getStatusId(self::STATUS_NEW);
    }

    public static function getStatusCanceledId(): int
    {
        return static::getStatusId(self::STATUS_CANCELED);
    }

    public static function getStatusInProcessId(): int
    {
        return static::getStatusId(self::STATUS_IN_PROCESS);
    }

    public static function getStatusCompletedId(): int
    {
        return static::getStatusId(self::STATUS_COMPLETED);
    }

    public static function getStatusFailedId(): int
    {
        return static::getStatusId(self::STATUS_FAILED);
    }
}
