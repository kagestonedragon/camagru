<?php

namespace Framework\Controllers\Posts;
use Framework\Controllers\Basic\Controller;
use Framework\Modules\Application;

class AddLike extends Controller
{
    const MODEL_ADD_LIKE = 'Posts@AddLike';
    const MODEL_NOTIFICATION = 'Notification@Notify';

    protected function process()
    {
        Application::setAjaxResult($this->addLike());
    }

    private function addLike()
    {
        global $dbTables;

        $result = Application::loadModel(
            AddLike::MODEL_ADD_LIKE,
            [
                'TABLE_POSTS' => $dbTables['POSTS'],
                'TABLE_CONNECTION' => $dbTables['USERS_POSTS_LIKES'],
            ]
        );

        if ($result['STATUS']['CODE'] == 200) {
            $this->addNotification($result['NOTIFY_USER_ID']);
            unset($result['NOTIFY_USER_ID']);
        }

        return ($result);
    }

    private function addNotification(string $userId)
    {
        global $dbTables;

        Application::loadModel(
            AddLike::MODEL_NOTIFICATION,
            [
                'TABLE' => $dbTables['NOTIFICATIONS'],
                'TABLE_USERS' => $dbTables['USERS'],
                'TYPE' => 1,
                'USER_ID_2' => $userId,
            ]
        );
    }
}