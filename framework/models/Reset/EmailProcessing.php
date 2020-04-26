<?php

namespace Framework\Models\Reset;
use Framework\Models\Basic\Model;
use Framework\Modules\ORM;
use Framework\Modules\Mail;

class EmailProcessing extends Model
{
    const URL_TEMPLATE = '/reset/#USERNAME#/#TOKEN#/';

    const STATUS = [
        'ERROR_DATA' => [
            'CODE' => 500,
            'TEXT' => 'Неверные данные',
        ],
        'ERROR_EMAIL' => [
            'CODE' => 501,
            'TEXT' => 'Пользователь не найден',
        ],
        'SUCCESS' => [
            'CODE' => 200,
            'TEXT' => 'Успешно',
        ]
    ];

    protected function process()
    {
        global $REQUEST;

        if ($this->validateData($REQUEST->arPost)) {
            $email = $REQUEST->arPost['email'];
            $user = $this->getUser($email);

            if (empty($user)) {
                $this->setStatus(EmailProcessing::STATUS['ERROR_EMAIL']);
            } else {
                $this->sendResetLink($user['username'], $user['email'], $user['token']);
                $this->setStatus(EmailProcessing::STATUS["SUCCESS"]);
            }
        }
    }

    private function validateData($data)
    {
        if (empty($data) || empty($data['email'])) {
            $this->setStatus(EmailProcessing::STATUS['ERROR_DATA']);
            return (false);
        }

        return (true);
    }

    private function getUser(string $email)
    {
        $result = (new ORM('#users'))
            ->select([
                'username',
                'token',
                'email',
            ])
            ->where('email=:email')
            ->execute([
                '#users' => $this->params['TABLE_USERS'],
                ':email' => $email,
            ]);

        return ($result);
    }

    private function sendResetLink(string $username, string $email, string $token)
    {
        $resetLink = 'https://' . env('SITE_DOMAIN') . EmailProcessing::URL_TEMPLATE;
        $resetLink = str_replace('#USERNAME#', $username, $resetLink);
        $resetLink = str_replace('#TOKEN#', $token, $resetLink);

        Mail::send(
            $email,
            'Восстановление пароля | Camagru',
            '<p>Заявка на сброс пароля. Для восстановление перейдите по <a href="' . $resetLink . '">ссылке</a>.'
        );
    }
}