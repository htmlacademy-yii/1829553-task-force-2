<?php

namespace app\fixtures;

use app\models\User;
use yii\test\ActiveFixture;

class UserFixture extends ActiveFixture
{
    public $modelClass = 'app\models\User';

    public function getAllIdSpecialist(): array
    {
        $roleFixture = new RoleFixture();
        $specialistRoleID = $roleFixture
            ->getRoleIDByName($roleFixture->getRoleNameSpecialist());
        return User::find()
            ->select('id')
            ->where(['id_role' => $specialistRoleID])
            ->column();
    }

    public function getRandomIdSpecialist(): int
    {
        $roleFixture = new RoleFixture();
        $specialistRoleID = $roleFixture
            ->getRoleIDByName($roleFixture->getRoleNameSpecialist());

        return $this->getRandomIdUser($specialistRoleID);
    }

    public function getRandomIdCustomer(): int
    {
        $roleFixture = new RoleFixture();
        $customerRoleID = $roleFixture
            ->getRoleIDByName($roleFixture->getRoleNameCustomer());

        return $this->getRandomIdUser($customerRoleID);
    }

    private function getRandomIdUser(int $idRole): int
    {
        $userIds = User::find()
            ->select('id')
            ->where(['id_role' => $idRole])
            ->column();

        return $this->getRandomItemFromArray($userIds);
    }

    private function getRandomItemFromArray(array $data): int
    {
        $key = array_rand($data);
        return $data[$key];
    }
}
