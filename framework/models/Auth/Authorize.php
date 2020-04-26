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
            'TEXT' => 'Неверные данные',
        ],
        'ERROR_USER' => [
            'CODE' => '501',
            'TEXT' => 'Пользователь не найден',
        ],
        'ERROR_VERIFIED' => [
            'CODE' => '502',
            'TEXT' => 'Подтвердите аккаунт',
        ],
        'ERROR_PASSWORD' => [
            'CODE' => '503',
            'TEXT' => 'Неверные пароль',
        ],
        'SUCCESS' => [
            'CODE' => '200',
            'TEXT' => 'Успешно',
        ],
    ];

    protected function process()
    {
        global $REQUEST;

        if ($this->validateData($REQUEST->arPost)) {
            $username = $REQUEST->arPost['username'];
            $password = $REQUEST->arPost['password'];

            $user = $this->getUser($username);
            if ($this->validateUser($user, $password)) {
                $this->authorize($user['id'], $user['username'], $user['email']);
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

    private function validateUser($user, string $password)
    {
        if (empty($user)) {
            $this->setStatus(Authorize::STATUS['ERROR_USER']);
            return (false);
        } else if ($user['password'] != RegistrationHelper::encryptPassword($password)) {
            $this->setStatus(Authorize::STATUS['ERROR_PASSWORD']);
            return (false);
        } else if ($user['verified'] == '0') {
            $this->setStatus(Authorize::STATUS['ERROR_VERIFIED']);
            return (false);
        }

        return (true);
    }

    /**
     * Метод авторизации пользователя
     * @param string $userId
     * @param string $username
     * @param string $email
     */
    private function authorize(string $userId, string $username, string $email)
    {
        global $USER;

        $USER->authorize($userId, $username, $email);
        $this->result['STATUS'] = Authorize::STATUS['SUCCESS'];
    }

    /**
     * Функция валидации (существование и соответствие паролей)
     * @param string $username
     * @param string $password
     * @return array|mixed|string
     */
    private function getUser(string $username)
    {
        $user = (new ORM('#users'))
            ->select([
                    'id',
                    'username',
                    'email',
                    'verified',
                    'password',
            ])
            ->where('username=:username')
            ->execute([
                    '#users' => $this->params['TABLE'],
                    ':username' => strtolower($username),
            ]);

        return ($user);
    }
}