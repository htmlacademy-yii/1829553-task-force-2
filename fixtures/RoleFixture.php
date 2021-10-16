<?php

namespace app\fixtures;

use app\models\Role;
use yii\test\ActiveFixture;

class RoleFixture extends ActiveFixture
{
    public $modelClass = 'app\models\Role';

    private const SPECIALIST = 'специалист';
    private const CUSTOMER = 'заказчик';

    public function getRoleIDByName(string $roleName): int
    {
        $role = Role::findOne(['name' => $roleName]);
        return $role->id;
    }

    public function getRoleNameSpecialist(): string
    {
        return self::SPECIALIST;
    }

    public function getRoleNameCustomer(): string
    {
        return self::CUSTOMER;
    }
}
