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
            'TEXT' => 'Неверно заполнены поля!',
        ],
        'ERROR_USER' => [
            'CODE' => '501',
            'TEXT' => 'Такого пользователя не существует! Возможно, неверно введены данные.',
        ],
        'ERROR_VERIFIED' => [
            'CODE' => '502',
            'TEXT' => 'Требуется подтвеждение аккаунта. Проверьте почтовый адрес!',
        ],
        'SUCCESS' => [
            'CODE' => '200',
            'TEXT' => 'Успешно ',
        ],
    ];

    protected function process()
    {
        global $REQUEST;

        if ($this->validateData($REQUEST->arPost)) {
            $username = $REQUEST->arPost['username'];
            $password = $REQUEST->arPost['password'];

            $user = $this->getUser($username, $password);
            if ($this->validateUser($user)) {
                $this->authorize($user['id'], $user['username']);
            }
        }
    }

    private function validateData($data)
    {
        if ((empty($data)) || empty($data['username']) || empty($data['password'])) {
            $this->result['STATUS'] = Authorize::STATUS['ERROR_FIELDS'];
            return (false);
        }

        return (true);
    }

    private function validateUser($user)
    {
        if (empty($user)) {
            $this->result['STATUS'] = Authorize::STATUS['ERROR_USER'];
            return (false);
        } else if ($user['verified'] == '0') {
            $this->result['STATUS'] = Authorize::STATUS['ERROR_VERIFIED'];
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
        $this->result['STATUS'] = Authorize::STATUS['SUCCESS'];
    }

    /**
     * Функция валидации (существование и соответствие паролей)
     * @param string $username
     * @param string $password
     * @return array|mixed|string
     */
    private function getUser(string $username, string $password)
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
                    ':username' => strtolower($username),
                    ':password' => RegistrationHelper::encryptPassword($password),
                ]
            );

        return ($user);
    }
}