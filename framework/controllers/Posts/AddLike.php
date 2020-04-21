<?php

namespace Framework\Controllers\Posts;
use Framework\Controllers\Basic\Controller;
use Framework\Modules\Application;

class AddLike extends Controller
{
    const MODEL = 'Posts@AddLike';

    protected function process()
    {
        Application::setAjaxResult($this->addLike());
    }

    private function addLike()
    {
        global $dbTables;

        $result = Application::loadModel(
            AddLike::MODEL,
            [
                'TABLE_POSTS' => $dbTables['POSTS'],
                'TABLE_CONNECTION' => $dbTables['USERS_POSTS_LIKES'],
            ]
        );

        return ($result);
    }
}