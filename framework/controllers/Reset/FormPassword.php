<?php

namespace Framework\Controllers\Reset;
use Framework\Controllers\Basic\Controller;
use Framework\Modules\Application;

class FormPassword extends Controller
{
    const VIEW = 'Reset^FormPassword';

    protected function process()
    {
        global $USER;

        if ($USER->isAuthorized()) {
            Application::redirect('/');
        }

        Application::loadHeader(SITE_SHORT_TEMPLATE);
        Application::loadView(FormPassword::VIEW);
        Application::loadFooter(SITE_SHORT_TEMPLATE);
    }
}