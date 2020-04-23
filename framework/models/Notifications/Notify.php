<?php

namespace Framework\Models;
use Framework\Models\Basic\Model;
use Framework\Modules\ORM;
use Framework\Modules\Mail;

class Notify extends Model
{
    const TYPES = [
        'COMMENTARY' => 0,
        'LIKE' => 1,
    ];

    protected function process()
    {
        global $USER;
        $userId2 = $this->params['USER_ID_2'];
        $postId = $this->params['POST_ID'];
        $type = $this->params['TYPE'];

        $this->addNotification($USER->getId(), $userId2, $postId, $type);
        $this->sendEmailNotification($USER->getUsername(), $this->getEmail($userId2), $type);
    }

    /**
     * Метод добавление уведомления в список в бд
     * @param string $userId1
     * @param string $userId2
     * @param string $postId
     * @param int $type
     */
    private function addNotification(string $userId1, string $userId2, string $postId, int $type)
    {
        (new ORM('#notifications'))
            ->insert([
                'user_id_1' => ':user_id_1',
                'user_id_2' => ':user_id_2',
                'post_id' => ':post_id',
                'type' => ':type',
            ])
            ->execute([
                '#notifications' => $this->params['TABLE'],
                ':user_id_1' => $userId1,
                ':user_id_2' => $userId2,
                ':post_id' => $postId,
                ':type' => $type,
            ]);
    }

    /**
     * Метод отправки уведомления на почту
     * @param string $username
     * @param string $email
     * @param int $type
     */
    private function sendEmailNotification(string $username, string $email, int $type)
    {
        $subject = '';
        $message = '';
        if ($type == Notify::TYPES['COMMENTARY']) {
            $subject = 'Новый комментарий | Camagru';
            $message = '<p>Пользователь ' . $username . ' оставил новый комментарий под вашим постом!</p>';
        } else if ($type == Notify::TYPES['LIKE']) {
            $subject = 'Новая оценка | Camagru';
            $message = '<p>Пользователь ' . $username . ' оценил ваш пост лайком!</p>';
        }

        if (!empty($subject) && !empty($message)) {
            Mail::send(
                $email,
                $subject,
                $message,
            );
        }

    }

    /**
     * Метод получению почты для пользователя получающего уведомление
     * @param string $userId
     * @return mixed
     */
    private function getEmail(string $userId)
    {
        $result = (new ORM('#users'))
            ->select([
                'email'
            ])
            ->where(':id = :user_id')
            ->execute([
                '#users' => $this->params['TABLE_USERS'],
                ':user_id' => $userId
            ]);

        return ($result['email']);
    }
}