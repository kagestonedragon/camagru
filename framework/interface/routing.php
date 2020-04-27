<?php

use Framework\Modules\Router;

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
        '/registration/',
        'Registration@FormProcessing',
    );

    Router::route(
        'get',
        '/registration/(\S*)/',
        'Registration@Verification', [
            'TOKEN' => 1,
        ]
    );

/**
 * Авторизация
 */
    Router::route(
        'get',
        '/auth/',
        'Auth@Form'
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
 * Сброс пароля
 */
    Router::route(
        'get',
        '/reset/',
        'Reset@FormEmail'
    );

    Router::route(
        'post',
        '/reset/',
        'Reset@FormEmailProcessing'
    );

    Router::route(
        'get',
        '/reset/(\S*)/(\S*)/',
        'Reset@FormPassword', [
            'USERNAME' => 1,
            'TOKEN' => 2,
        ]
    );

    Router::route(
        'post',
        '/reset/process/',
        'Reset@FormPasswordProcessing'
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
        '/add/',
        'Posts@AddPost'
    );

    Router::route(
        'patch',
        '/items/([0-9]+)/likes/add/',
        'Posts@AddLike',
        [
            'ID' => 1,
        ]
    );

    Router::route(
        'patch',
        '/items/([0-9]+)/likes/delete/',
        'Posts@DeleteLike',
        [
            'ID' => 1,
        ]
    );