<?php

namespace Framework\Controllers\Reset;
use Framework\Controllers\Basic\Controller;
use Framework\Modules\Application;

class FormEmailProcessing extends Controller
{
    const MODEL = 'Reset@EmailProcessing';

    protected function process()
    {
        Application::setAjaxResult(
            $this->getResult(FormEmailProcessing::MODEL)
        );
    }

    private function getResult(string $model)
    {
        global $dbTables;

        $result = Application::loadModel(
            $model, [
                'TABLE_USERS' => $dbTables['USERS'],
            ]
        );

        return ($result);
    }
}