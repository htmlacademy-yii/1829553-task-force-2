<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user_skill".
 *
 * @property int $id
 * @property int $id_specialist
 * @property int $id_skill
 *
 * @property Skill $skill
 * @property User $specialist
 */
class UserSkill extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_skill';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_specialist', 'id_skill'], 'required'],
            [['id_specialist', 'id_skill'], 'integer'],
            [
                ['id_specialist', 'id_skill'],
                'unique',
                'targetAttribute' => ['id_specialist', 'id_skill']],
            [
                ['id_skill'],
                'exist',
                'skipOnError' => true,
                'targetClass' => Skill::className(),
                'targetAttribute' => ['id_skill' => 'id']],
            [
                ['id_specialist'],
                'exist',
                'skipOnError' => true,
                'targetClass' => User::className(),
                'targetAttribute' => ['id_specialist' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_specialist' => 'ID Специалиста',
            'id_skill' => 'ID Навыка',
        ];
    }

    /**
     * Gets query for [[Skill]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSkill()
    {
        return $this->hasOne(Skill::className(), ['id' => 'id_skill']);
    }

    /**
     * Gets query for [[Specialist]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSpecialist()
    {
        return $this->hasOne(User::className(), ['id' => 'id_specialist']);
    }
}
