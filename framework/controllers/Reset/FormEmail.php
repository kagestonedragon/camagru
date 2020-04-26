<?php

namespace Framework\Controllers\Reset;
use Framework\Controllers\Basic\Controller;
use Framework\Modules\Application;

class FormEmail extends Controller
{
    const VIEW = 'Reset^FormEmail';

    protected function process()
    {
        Application::loadHeader(SITE_SHORT_TEMPLATE);
        Application::loadView(FormEmail::VIEW);
        Application::loadFooter(SITE_SHORT_TEMPLATE);
    }
}