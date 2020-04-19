<?php

namespace Framework\Models\Registration;

use Framework\Helpers\Registration as RegistrationHelper;
use Framework\Models\Basic\Model;
use Framework\Modules\Debugger;
use Framework\Modules\ORM;
use Framework\Modules\Mail;

class Register extends Model
{
    const VERIFICATION_LINK = '/registration/#TOKEN#/';

    const STATUS = [
        'ERROR_FIELDS' => [
            'CODE' => '500',
            'TEXT' => 'Неверно заполнены поля!',
        ],
        'ERROR_EXISTS' => [
            'CODE' => '501',
            'TEXT' => 'Такой пользователь уже существует!',
        ],
        'ERROR_PASSWORD' => [
            'CODE' => '502',
            'TEXT' => 'Пароль не совпадают!',
        ],
        'SUCCESS' => [
            'CODE' => '200',
            'TEXT' => 'На почту #EMAIL# отправлена ссылка для подтвеждения аккаунта!',
        ],
    ];

    private string $token = '';

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

    protected function Process()
    {
        global $REQUEST;

        if ($this->validateData($REQUEST->arPost)) {
            if ($this->validatePasswords($REQUEST->arPost['password'], $REQUEST->arPost['password-confirm'])) {
                if ($this->isUserNotExists($REQUEST->arPost['username'], $REQUEST->arPost['email'])) {
                    $this->addUser(
                        $REQUEST->arPost['username'],
                        $REQUEST->arPost['email'],
                        $REQUEST->arPost['password']
                    );

                    $this->sendVerificationLink($REQUEST->arPost['email'], $this->token);
                }
            }
        }
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