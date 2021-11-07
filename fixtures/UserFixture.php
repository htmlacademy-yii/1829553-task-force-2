<?php

namespace app\fixtures;

use app\models\User;
use yii\test\ActiveFixture;

class UserFixture extends ActiveFixture
{
    public $modelClass = 'app\models\User';

    public function getAllPerformerId(): array
    {
        return User::find()
            ->select('id')
            ->where(['is_client' => !User::CLIENT])
            ->column();
    }

    public function getRandomPerformerId(): int
    {
        return $this->getRandomUserId(false);
    }

    public function getRandomClientId(): int
    {
        return $this->getRandomUserId(true);
    }

    private function getRandomUserId(bool $is_client): int
    {
        $userIds = User::find()
            ->select('id')
            ->where(['is_client' => $is_client])
            ->column();

        return $this->getRandomItemFromArray($userIds);
    }

    private function getRandomItemFromArray(array $data): int
    {
        $key = array_rand($data);
        return $data[$key];
    }
}
