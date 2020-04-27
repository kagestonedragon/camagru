<?php

namespace Framework\Controllers\Registration;
use Framework\Controllers\Basic\Controller;
use Framework\Modules\Application;

class Verification extends Controller
{
    const VIEW = 'Registration^Verification';
    const MODEL = 'Registration@Verify';

    protected function process()
    {
        global $USER;

        if ($USER->isAuthorized()) {
            Application::redirect('/');
        }

        Application::loadHeader(SITE_SHORT_TEMPLATE);
        Application::loadView(
            Verification::VIEW,
            $this->verify(Verification::MODEL)
        );
        Application::loadFooter(SITE_SHORT_TEMPLATE);
    }

    private function verify(string $model)
    {
        global $dbTables;

        $result = Application::loadModel(
            $model,
            [
                'TABLE' => $dbTables['USERS'],
            ]
        );

        return ($result);
    }
}