<?php

namespace Framework\Controllers\Auth;
use Framework\Controllers\Basic\Controller;
use Framework\Modules\Application;

class Form extends Controller
{
    const VIEW = 'Auth^NewForm';

    protected function process()
    {
        global $USER;

        if ($USER->isAuthorized()) {
            Application::redirect('/');
        }

        Application::loadHeader(SITE_SHORT_TEMPLATE);
        Application::loadView(Form::VIEW);
        Application::loadFooter(SITE_SHORT_TEMPLATE);
    }
}