<?php

namespace Framework\Controllers\Reset;
use Framework\Controllers\Basic\Controller;
use Framework\Modules\Application;

class FormPasswordProcessing extends Controller
{
    const MODEL = 'Reset@PasswordProcessing';

    const UPDATE_TOKEN_MODE = 'Users@UpdateToken';

    protected function process()
    {
        global $USER;

        if ($USER->isAuthorized()) {
            Application::redirect('/');
        }

        Application::setAjaxResult(
            $this->updatePassword()
        );
    }

    private function updatePassword()
    {
        global $dbTables;
        global $REQUEST;

        $result = Application::loadModel(
            FormPasswordProcessing::MODEL, [
                'TABLE_USERS' => $dbTables['USERS'],
            ]
        );

        if ($result['STATUS']['CODE'] == 200) {
            Application::loadModel(
                FormPasswordProcessing::UPDATE_TOKEN_MODE, [
                    'TABLE_USERS' => $dbTables["USERS"],
                    'USERNAME' => $REQUEST->arPost['username'],
                ]
            );
        }

        return ($result);
    }
}