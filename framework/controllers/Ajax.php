<?php

namespace Framework\Controllers;
use Framework\Controllers\Controller;

/**
 * Class Ajax
 * @package Framework\Controllers
 *
 * TODO
 * Написать ajax модель для запроса
 * Написать получение данных на фронте
 */
class Ajax extends Controller
{
    const ADD_COMMENTARY = [
        'MODEL' => 'Posts::AddCommentary',
    ];
    const GET_ITEMS = [
        'MODEL' => 'Posts::GetList',
    ];
    const FORM_AUTH = [
        'MODEL' => 'Auth::Authorize',
    ];
    const FORM_REGISTRATION = [
        'MODEL' => 'Registration::Register',
    ];

    protected function process()
    {
        global $REQUEST;

        $action = $REQUEST->arGet['ACTION'];
        if ($action == 'COMMENTARY_ADD') {
            $this->addCommentary(Ajax::ADD_COMMENTARY['MODEL']);
        } else if ($action == 'GET_ITEMS') {
            $this->getItems(Ajax::GET_ITEMS['MODEL']);
        } else if ($action == 'FORM_AUTH') {
            $this->auth(Ajax::FORM_AUTH['MODEL']);
        } else if ($action == 'FORM_REGISTRATION') {
            $this->registration(Ajax::FORM_REGISTRATION['MODEL']);
        }
    }

    private function registration(string $model)
    {
        global $APPLICATION;
        global $dbTables;

        $params = [
            'TABLE' => $dbTables['USERS'],
        ];
        $result = $APPLICATION->loadModel($model, $params);

        echo json_encode($result);
    }

    private function auth(string $model)
    {
        global $APPLICATION;
        global $dbTables;

        $params = [
            'TABLE' => $dbTables['USERS'],
        ];
        $result = $APPLICATION->loadModel($model, $params);

        echo json_encode($result);
    }

    private function addCommentary(string $model)
    {
        global $APPLICATION;
        global $dbTables;

        $params = [
            'TABLE' => $dbTables['COMMENTARIES'],
            'TABLE_CONNECTION' => $dbTables['USERS_POSTS_COMMENTARIES'],
        ];
        $result = $APPLICATION->loadModel($model, $params);

        echo json_encode($result);
    }

    private function getItems(string $model)
    {
        global $APPLICATION;
        global $dbTables;

        $params = [
            'TABLE' => $dbTables['POSTS'],
            'TABLE_CONNECTION' => $dbTables['USERS_POSTS'],
            'TABLE_USERS' => $dbTables['USERS'],
            'TABLE_COMMENTARIES' => $dbTables['COMMENTARIES'],
            'TABLE_COMMENTARIES_CONNECTION' => $dbTables['USERS_POSTS_COMMENTARIES'],
            'TABLE_LIKES' => $dbTables['USERS_POSTS_LIKES'],
        ];

        $result = $APPLICATION->loadModel($model, $params);

        echo json_encode($result);

    }
}