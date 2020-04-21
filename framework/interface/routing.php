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
        '/registration/new/',
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

/**
 * Посты
 */

    Router::route(
        'get',
        '/',
        'Posts@GetList'
    );