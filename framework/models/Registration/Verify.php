<?php

namespace Framework\Models\Registration;
use Framework\Controllers\Registration\Verification;
use Framework\Models\Basic\Model;
use Framework\Modules\ORM;

class Verify extends Model
{
    const STATUS = [
        'ERROR_ALREADY_VERIFIED' => [
            'CODE' => 500,
            'TEXT' => 'Пользователь уже верифицирован',
        ],
        'ERROR_NOT_VALID_TOKEN' => [
            'CODE' => 501,
            'TEXT' => 'Невалидный токен',
        ],
        'SUCCESS' => [
            'CODE' => 200,
            'TEXT' => 'Успешно!'
        ]
    ];

    protected function process()
    {
        global $REQUEST;

        $token = $REQUEST->arGet['TOKEN'];
        $code = $this->validateVerification($token);

        if ($code == Verify::STATUS['SUCCESS']['CODE']) {
            $this->verify($token);
        }
    }

    private function verify(string $token)
    {
        (new ORM('#users'))
            ->update([
                "verified" => '1',
            ])
            ->where('token=:token')
            ->execute([
                '#users' => $this->params['TABLE'],
                ':token' => $token,
            ]);
    }

    private function validateVerification(string $token)
    {
        $result = (new ORM('#users'))
            ->select([
                'verified'
            ])
            ->where('token=:token')
            ->execute([
                '#users' => $this->params['TABLE'],
                ':token' => $token,
            ]);

        if (empty($result)) {
            $this->setStatus(Verify::STATUS['ERROR_NOT_VALID_TOKEN']);
        } else if ($result['verified'] == 1) {
            $this->setStatus(Verify::STATUS['ERROR_ALREADY_VERIFIED']);
        } else {
            $this->setStatus(Verify::STATUS['SUCCESS']);
        }

        return ($this->result['STATUS']['CODE']);
    }
}