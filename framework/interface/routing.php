<?php

use Framework\Modules\Router;
/**
 * @noinspection PhpIncludeInspection
 */

/**
 * Регистрация
 */
    Router::route(
        'get',
        '/registration/',
        'Registration@Form',
    );

    Router::route(
        'post',
        '/registration/post/',
        'Registration@FormProcessing',
    );

    Router::route(
        'patch',
        '/registration/(\S*)/',
        'Registration@Validation',
    );

/**
 * Авторизация
 */
    Router::route(
        'get',
        '/auth/',
        'Auth@Form',
    );

    Router::route(
        'post',
        '/auth/',
        'Auth@FormProcessing'
    );

    Router::route(
        'get',
        '/logout/',
        'Auth@Logout'
    );

/**
 * Посты
 */

    Router::route(
        'get',
        '/',
        'Posts@GetList'
    );

    Router::route(
        'get',
        '/items/([0-9]+)/likes/add/',
        'Posts@AddLike',
        [
            'ID' => 1,
        ]
    );