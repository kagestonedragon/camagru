<?php

namespace Framework\Modules\Reset;
use Framework\Models\Basic\Model;
use Framework\Modules\ORM;
use Framework\Helpers\Registration as RegistrationHelper;

class PasswordProcessing extends Model
{
    const PATTERNS = [
        'PASSWORD' => [
            'LENGTH' => 32,
            'PATTERN' => '/[\s+]/',
        ],
    ];

    const STATUS = [
        'ERROR_DATA' => [
            'CODE' => 500,
            'TEXT' => 'Неверные данные',
        ],
        'ERROR_PASSWORD' => [
            'CODE' => 501,
            'TEXT' => 'Пароли не совпадают',
        ],
        'ERROR_PASSWORD_LENGTH' => [
            'CODE' => 502,
            'TEXT' => 'Длинные пароль',
        ],
        'ERROR_PASSWORD_PATTERN' => [
            'CODE' => 503,
            'TEXT' => 'Неверный пароль',
        ],
        'ERROR_USER' => [
            'CODE' => 504,
            'TEXT' => 'Неверный пользователь'
        ],
        'ERROR_TOKEN' => [
            'CODE' => 505,
            'TEXT' => 'Неверный токен',
        ],
        'SUCCESS' => [
            'CODE' => 200,
            'TEXT' => 'Успешно!',
        ],
    ];

    protected function process()
    {
        global $REQUEST;

        if ($this->validateData($REQUEST->arPost)) {
            $username = $REQUEST->arPost['username'];
            $token = $REQUEST->arPost['token'];
            $password = $REQUEST->arPost['password'];
            $password_confirm = $REQUEST->arPost['password-confirm'];

            if ($this->validatePassword($password) && $this->validatePasswords($password, $password_confirm)) {
                if ($this->validateUser($username, $token)) {
                    $this->updatePassword($username, $password);
                    $this->setStatus(PasswordProcessing::STATUS['SUCCESS']);
                }
            }
        }
    }

    private function updatePassword(string $username, string $password)
    {
        (new ORM('#users'))
            ->update([
                'password' => RegistrationHelper::encryptPassword($password),
            ])
            ->where('username=:username')
            ->execute([
                '#users' => $this->params['TABLE_USERS']
            ]);
    }

    private function validateData($data)
    {
        if (empty($data) || empty($data['password']) || empty($data['password-confirm'])) {
            $this->setStatus(PasswordProcessing::STATUS['ERROR_DATA']);
            return (false);
        }

        return (true);
    }

    private function validatePassword(string $password)
    {
        if (strlen($password) > PasswordProcessing::PATTERNS['PASSWORD']['LENGTH']) {
            $this->setStatus(PasswordProcessing::STATUS['ERROR_PASSWORD_LENGTH']);
            return (false);
        } else {
            $chars = str_split($password);
            foreach ($chars as $char) {
                if (preg_match(PasswordProcessing::PATTERNS['PASSWORD']['PATTERN'], $char)) {
                    $this->setStatus(PasswordProcessing::STATUS['ERROR_PASSWORD_PATTERN']);
                    return (false);
                }
            }
        }

        return (true);
    }

    private function validatePasswords(string $password, string $password_confirm)
    {
        if ($password != $password_confirm) {
            $this->setStatus(PasswordProcessing::STATUS['ERROR_PASSWORD']);
            return (false);
        }

        return (true);
    }

    private function validateUser(string $username, string $token)
    {
        $result = (new ORM('#users'))
            ->select([
                'id',
                'token',
            ])
            ->where('username=:username')
            ->execute([
                '#users' => $this->params['TABLE_USERS'],
                ':username' => $username,
                ':token' => $token,
            ]);

        if (empty($result)) {
            $this->setStatus(PasswordProcessing::STATUS['ERROR_USER']);
            return (false);
        } else if ($result['token'] != $token) {
            $this->setStatus(PasswordProcessing::STATUS['ERROR_TOKEN']);
            return (false);
        }

        return (true);
    }
}