<?php

namespace Framework\Models\Registration;

use Framework\Helpers\Registration as RegistrationHelper;
use Framework\Models\Basic\Model;
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
            'TEXT' => 'Успешно!',
        ],
    ];

    private string $token = '';

    protected function Process()
    {
        global $REQUEST;

        if ($this->isUserNotExists($REQUEST->arPost['username'], $REQUEST->arPost['email'])) {
            $this->addUser(
                $REQUEST->arPost['username'],
                $REQUEST->arPost['email'],
                $REQUEST->arPost['password']
            );

            $this->result['email'] = $REQUEST->arPost['email'];
            $this->sendVerificationLink($this->result['email'], $this->token);
            $this->setStatus(Register::STATUS['SUCCESS']);
        } else {
            $this->setStatus(Register::STATUS['ALREADY_EXISTS']);
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
                ':username' => $username,
                ':email' => $email,
            ]);

        return (empty($user) ? true : false);
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
                ':username' => $username,
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
    }
}