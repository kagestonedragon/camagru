<?php

namespace Framework\Controllers\Registration;
use Framework\Controllers\Basic\Controller;
use Framework\Modules\Application;

class Form extends Controller
{
    const VIEW = 'Registration^Form';

    protected function process()
    {
        Application::loadHeader(SITE_DEFAULT_TEMPLATE);
        Application::loadView(Form::VIEW);
        Application::loadFooter(SITE_DEFAULT_TEMPLATE);
    }
}