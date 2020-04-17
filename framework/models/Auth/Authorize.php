<?php

namespace Framework\Models\Auth;

use Framework\Models\Basic\Model;
use Framework\Helpers\Registration as RegistrationHelper;
use Framework\Modules\ORM;

/**
 * Class Auth
 * @package Framework\Components
 *
 * TODO
 * 1. Доработать логику
 * 2. Написать логирование ошибок
 * 3. Написать Ajax метод для js
 */
class Authorize extends Model
{
    const STATUS = [
        'ERROR_FIELDS' => [
            'CODE' => '500',
            'TEXT' => 'Не верно заполненые поля!',
        ],
        'ERROR_USER' => [
            'CODE' => '501',
            'TEXT' => 'Такого пользователя не существует!',
        ],
        'ERROR_VERIFIED' => [
            'CODE' => '502',
            'TEXT' => 'Требуется подтвеждение аккаунта. Проверьте почтовый адресQ',
        ],
        'SUCCESS' => [
            'CODE' => '200',
            'TEXT' => 'Успешно ',
        ],
    ];

    protected function Process()
    {
        global $REQUEST;

        $username = $REQUEST->arPost['username'];
        $password = $REQUEST->arPost['password'];
        if ($this->validateData($username, $password)) {
            if ($user = $this->validateUser($username, $password)) {
                $this->authorize($user['id'], $user['username']);
                $this->result['status'] = Authorize::STATUS['SUCCESS'];
            }
        } else {
            $this->result['status'] = Authorize::STATUS['ERROR_FIELDS'];
        }

    }

    private function validateData($username, $password)
    {
        if (empty($username) || $username == '') {
            return (false);
        } else if (empty($password) || $password == '') {
            return (false);
        }

        return (true);
    }

    /**
     * Метод авторизации пользователя
     * @param string $userId
     * @param string $username
     */
    private function authorize(string $userId, string $username)
    {
        global $USER;

        $USER->authorize($userId, $username);
    }

    /**
     * Функция валидации (существование и соответствие паролей)
     * @param string $username
     * @param string $password
     * @return array|mixed|string
     */
    private function validateUser(string $username, string $password)
    {
        $user = (new ORM('#users'))
            ->select([
                    'id',
                    'username',
                    'verified',
            ])
            ->where('username=:username')
            ->and('password=:password')
            ->execute(
                [
                    '#users' => $this->params['TABLE'],
                    ':username' => $username,
                    ':password' => RegistrationHelper::encryptPassword($password),
                ]
            );

        if (empty($user)) {
            $this->result['status'] = Authorize::STATUS['ERROR_USER'];
            return (false);
        } else if ($user['verified'] == '0') {
            $this->result['status'] = Authorize::STATUS['ERROR_VERIFIED'];
            return (false);
        } else {
            return ($user);
        }
    }

}