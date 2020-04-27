<?php

namespace Framework\Models\Users;
use Framework\Models\Basic\Model;
use Framework\Modules\ORM;
use Framework\Helpers\Registration as RegistrationHelper;

class UpdateToken extends Model
{
    protected function process()
    {
        $this->updateToken($this->params['USERNAME']);
    }

    private function updateToken(string $username)
    {
        (new ORM('#users'))
            ->update([
                'token' => ':token',
            ])
            ->where('username=:username')
            ->execute([
                '#users' => $this->params['TABLE_USERS'],
                ':username' => $username,
                ':token' => RegistrationHelper::generateToken($username),
            ]);
    }
}