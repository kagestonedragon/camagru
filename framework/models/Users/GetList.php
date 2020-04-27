<?php

namespace Framework\Models\Users;
use Framework\Models\Basic\Model;
use Framework\Modules\ORM;

class GetList extends Model
{
    protected function process()
    {
        $this->result = $this->getUsers();
    }

    private function getUsers()
    {
        $result = (new ORM('#users'))
            ->select([
                'id',
                'username',
            ])
            ->order(
                'id',
                'DESC',
            )
            ->limit($this->params['LIMIT'])
            ->execute([
                '#users' => $this->params['TABLE_USERS'],
            ]);

        return ($result);
    }
}