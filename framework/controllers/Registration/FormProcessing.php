<?php

namespace Framework\Controllers\Registration;
use Framework\Controllers\Basic\Controller;
use Framework\Modules\Application;

class FormProcessing extends Controller
{
    const MODEL = 'Registration@Register';

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