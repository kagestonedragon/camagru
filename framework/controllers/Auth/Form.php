<?php

namespace Framework\Controllers\Auth;
use Framework\Controllers\Basic\Controller;
use Framework\Modules\Application;

class Form extends Controller
{
    const VIEW = 'Auth^Form';

    protected function process()
    {
        Application::loadHeader(SITE_DEFAULT_TEMPLATE);
        Application::loadView(Form::VIEW);
        Application::loadFooter(SITE_DEFAULT_TEMPLATE);
    }
}