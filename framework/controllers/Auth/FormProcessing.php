<?php

namespace Framework\Controllers\Auth;
use Framework\Controllers\Basic\Controller;
use Framework\Modules\Application;

class FormProcessing extends Controller
{
    const MODEL = 'Auth@Authorize';

    protected function process()
    {
        global $dbTables;

        Application::setAjaxResult(
            Application::loadModel(
                FormProcessing::MODEL,
                [
                    'TABLE' => $dbTables['USERS'],
                ]
            )
        );
    }
}