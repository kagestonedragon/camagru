<?php

namespace Framework\Models\Registration;

use Framework\Helpers\Registration as RegistrationHelper;
use Framework\Models\Auth\Authorize;
use Framework\Models\Basic\Model;
use Framework\Modules\Debugger;
use Framework\Modules\ORM;
use Framework\Modules\Mail;
use MongoDB\BSON\Regex;

class Register extends Model
{
    const VERIFICATION_LINK = '/registration/#TOKEN#/';

    const PATTERNS = [
        'EMAIL' => [
            'LENGTH' => 32,
            'PATTERN' => '/^(\S+)@(\S+)\.(\S+)$/'
        ],
        'USERNAME' => [
            'LENGTH' => 32,
            'PATTERN' => '/[a-zA-Z]|[0-9]|_/',
        ],
        'PASSWORD' => [
            'LENGTH' => 32,
            'PATTERN' => '/[\s+]/',
        ],
    ];

    const STATUS = [
        'ERROR_FIELDS' => [
            'CODE' => 500,
            'TEXT' => 'Неверные данные',
        ],
        'ERROR_EXISTS' => [
            'CODE' => 501,
            'TEXT' => 'Такой пользователь существует',
        ],
        'ERROR_PASSWORD' => [
            'CODE' => 502,
            'TEXT' => 'Пароли не совпадают',
        ],
        'ERROR_USERNAME_LENGTH' => [
            'CODE' => 503,
            'TEXT' => 'Длинное имя пользователя'
        ],
        'ERROR_USERNAME_PATTERN' => [
            'CODE' => 504,
            'TEXT' => 'Неверное имя пользователя',
        ],
        'ERROR_EMAIL_LENGTH' => [
            'CODE' => 505,
            'TEXT' => 'Длинный почтовый адрес',
        ],
        'ERROR_EMAIL_PATTERN' => [
            'CODE' => 506,
            'TEXT' => 'Неверный почтовый адрес',
        ],
        'ERROR_PASSWORD_LENGTH' => [
            'CODE' => 507,
            'TEXT' => 'Длинный пароль',
        ],
        'ERROR_PASSWORD_PATTERN' => [
            'CODE' => 508,
            'TEXT' => 'Неверный пароль',
        ],
        'SUCCESS' => [
            'CODE' => 200,
            'TEXT' => 'На почту #EMAIL# отправлена ссылка для подтвеждения аккаунта!',
        ],
    ];

    private string $token = '';

    protected function process()
    {
        global $REQUEST;

        if ($this->validateData($REQUEST->arPost)) {
            $username = $REQUEST->arPost['username'];
            $email = $REQUEST->arPost['email'];
            $password = $REQUEST->arPost['password'];
            $password_confirm = $REQUEST->arPost['password-confirm'];

            if ($this->validateUsername($username) && $this->validateEmail($email) && $this->validatePassword($password)) {
                if ($this->validatePasswords($password, $password_confirm)) {
                    if ($this->isUserNotExists($username, $email)) {
                        $this->addUser(
                            $username,
                            $email,
                            $password
                        );

                        $this->sendVerificationLink($email, $this->token);
                    }
                }
            }
        }
    }

    private function validateUsername(string $username)
    {
        if (strlen($username) > Register::PATTERNS['USERNAME']['LENGTH']) {
            $this->setStatus(Register::STATUS['ERROR_USERNAME_LENGTH']);
            return (false);
        } else {
            $chars = str_split($username);
            foreach ($chars as $char) {
                if (!preg_match(Register::PATTERNS['USERNAME']['PATTERN'], $char)) {
                    $this->setStatus(Register::STATUS['ERROR_USERNAME_PATTERN']);
                    return (false);
                }
            }
        }

        return (true);
    }

    private function validateEmail(string $email)
    {
        if (strlen($email) > Register::PATTERNS['EMAIL']['LENGTH']) {
            $this->setStatus(Register::STATUS['ERROR_EMAIL_LENGTH']);
            return (false);
        } else {
            if (!preg_match(Register::PATTERNS["EMAIL"]['PATTERN'], $email)) {
                $this->setStatus(Register::STATUS["ERROR_EMAIL_PATTERN"]);
                return (false);
            }
        }

        return (true);
    }

    private function validatePassword(string $password)
    {
        if (strlen($password) > Register::PATTERNS['PASSWORD']['LENGTH']) {
            $this->setStatus(Register::STATUS['ERROR_PASSWORD_LENGTH']);
            return (false);
        } else {
            $chars = str_split($password);
            foreach ($chars as $char) {
                if (preg_match(Register::PATTERNS['PASSWORD']['PATTERN'], $char)) {
                    $this->setStatus(Register::STATUS['ERROR_PASSWORD_PATTERN']);
                    return (false);
                }
            }
        }

        return (true);
    }

    private function validateData($data)
    {
        if (empty($data) ||
            empty($data['username']) ||
            empty($data['password']) ||
            empty($data['password-confirm']) ||
            empty($data['email'])
        ) {
            $this->result['STATUS'] = Register::STATUS['ERROR_FIELDS'];
            return (false);
        }

        return (true);
    }

    private function validatePasswords(string $password, string $password_confirm) {
        if ($password !== $password_confirm) {
            $this->result['STATUS'] = Register::STATUS['ERROR_PASSWORD'];
            return (false);
        }

        return (true);
    }

    /**
     * Метод проверки пользователя на существование
     * @param string $username
     * @param string $email
     * @return bool
     */
    private function isUserNotExists(string $username, string $email)
    {
        $user = (new ORM('#users'))
            ->select([
                'id'
            ])
            ->where('username=:username')
            ->or('email=:email')
            ->execute([
                '#users' => $this->params['TABLE'],
                ':username' => strtolower($username),
                ':email' => $email,
            ]);

        if (!empty ($user)) {
            $this->result['STATUS'] = Register::STATUS['ERROR_EXISTS'];
            return (false);
        } else {
            return (true);
        }
    }

    /**
     * Метод добавление нового пользователя
     * @param string $username
     * @param string $email
     * @param string $password
     */
    private function addUser(string $username, string $email, string $password)
    {
        $this->token = RegistrationHelper::generateToken($username);

        (new ORM('#users'))
            ->insert([
                'username' => ':username',
                'email' => ':email',
                'password' => ':password',
                'token' => ':token',
            ])
            ->execute([
                '#users' => $this->params['TABLE'],
                ':username' => strtolower($username),
                ':email' => $email,
                ':password' => RegistrationHelper::encryptPassword($password),
                ':token' => $this->token,
            ]);
    }

    private function sendVerificationLink(string $email, string $token)
    {
        $verificationLink = 'https://' . env('SITE_DOMAIN') . str_replace('#TOKEN#', $token, Register::VERIFICATION_LINK);

        Mail::send(
            $email,
            'Завершение регистрации | Camagru',
            '<p>Вы успешно зарегистрировались на сайте. Для завершения перейти по ссылке <a href="' . $verificationLink . '">подтвеждения</a>.'
        );

        $this->result['STATUS'] = Register::STATUS['SUCCESS'];
        $this->result['STATUS']['TEXT'] = str_replace('#EMAIL#', $email, $this->result['STATUS']['TEXT']);
    }
}