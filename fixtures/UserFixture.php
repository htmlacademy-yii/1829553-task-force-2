<?php

namespace app\fixtures;

use app\models\User;
use yii\test\ActiveFixture;

class UserFixture extends ActiveFixture
{
    public $modelClass = 'app\models\User';

    public function getRandomUserIDByRole(int $roleId)
    {
        $userIds = User::find()
            ->select('id')
            ->where(['id_role' => $roleId])
            ->column();

        return $this->getRandomItemFromArray($userIds);
    }

    private function getRandomUserID(?int $busedUserID = null)
    {
        $userIds = User::find()
            ->select('id')
            ->column();

        if (empty($busedUserID)) {
            return $this->getRandomItemFromArray($userIds);
        }

        do {
            $userID = $this->getRandomItemFromArray($userIds);
        } while ($userID == $busedUserID);
        return $userID;
    }

    private function getRandomItemFromArray(array $data)
    {
        $key = array_rand($data);
        return $data[$key];
    }
}
