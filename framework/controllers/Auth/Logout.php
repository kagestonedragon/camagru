<?php

namespace Framework\Controllers\Auth;
use Framework\Controllers\Basic\Controller;
use Framework\Modules\Application;

class Logout extends Controller
{
    const MODEL = 'Auth@Logout';

    protected function process()
    {
        Application::loadModel(Logout::MODEL);
        Application::redirect('/');
    }
}