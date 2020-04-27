<?php

namespace Framework\Controllers\Posts;
use Framework\Controllers\Basic\Controller;
use Framework\Modules\Application;

class AddPost extends Controller
{
    const VIEW = 'Posts^photo';

    protected function process()
    {
        global $USER;

        if (!$USER->isAuthorized()) {
            Application::redirect('/auth/');
        }

        Application::loadHeader(SITE_DEFAULT_TEMPLATE);
        Application::loadView(AddPost::VIEW);
        Application::loadFooter(SITE_DEFAULT_TEMPLATE);
    }
}