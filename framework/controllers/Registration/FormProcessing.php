<?php

namespace Framework\Controllers\Registration;
use Framework\Controllers\Basic\Controller;
use Framework\Modules\Application;

class FormProcessing extends Controller
{
    const MODEL = 'Registration@Register';

    protected function process()
    {
        global $USER;

        if ($USER->isAuthorized()) {
            Application::redirect('/');
        }

        Application::setAjaxResult(
            $this->getResult(FormProcessing::MODEL)
        );
    }

    private function getResult(string $model)
    {
        global $dbTables;

        $result = Application::loadModel(
            $model, [
                'TABLE' => $dbTables['USERS'],
            ]
        );

        return ($result);
    }
}