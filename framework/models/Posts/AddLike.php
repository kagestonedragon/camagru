<?php

namespace Framework\Models\Posts;
use Framework\Models\Basic\Model;
use Framework\Modules\ORM;
use Framework\Helpers\Posts as PostsHelper;

/**
 * Class AddLike
 * @package Framework\Models\Posts
 */
class AddLike extends Model
{
    const STATUS = [
        'ERROR_LIKE_EXISTS' => [
            'CODE' => 500,
            'TEXT' => 'Лайк уже проставлен для этой фотографии!',
        ],
        'SUCCESS' => [
            'CODE' => 200,
            'TEXT' => 'Лайк успешно поставлен!',
        ],
    ];

    protected function process()
    {
        global $USER;
        global $REQUEST;

        $userId = $USER->getId();
        $postId = $REQUEST->arGet['ID'];
        if ($this->validateLike($postId, $userId)) {
            $this->addLike($postId);
            $this->addConnection($postId, $userId);
            $result['NOTIFY_USER_ID'] = PostsHelper::getPostAuthor($postId);
            $this->setStatus(AddLike::STATUS['SUCCESS']);
        }
    }

    /**
     * Метод добавления лайка на фотографию
     * @param string $postId
     */
    private function addLike(string $postId)
    {
        (new ORM('#posts'))
            ->update([
                'likes ' => ' likes + 1',
            ])
            ->where('id=:post_id')
            ->execute([
                '#posts' => $this->params['TABLE'],
                ':post_id' => $postId,
            ]);
    }

    /**
     * Метод добавление связи
     * @param string $postId
     * @param string $userId
     */
    private function addConnection(string $postId, string $userId)
    {
        (new ORM('#connection'))
            ->insert([
                'user_id' => ':user_id',
                'post_id' => ':post_id',
            ])
            ->execute([
                '#connection' => $this->params['TABLE_CONNECTION'],
                ':user_id' => $userId,
                ':post_id' => $postId,
            ]);
    }

    /**
     * Метод валидации лайка (вдруг он уже есть?)
     * @param string $postId
     * @param string $userId
     * @return bool
     */
    private function validateLike(string $postId, string $userId)
    {
        $result = (new ORM('#connection'))
            ->select([
                'id'
            ])
            ->where('user_id=:user_id')
            ->and('post_id=:post_id')
            ->execute([
                '#connection' => $this->params['TABLE_CONNECTION'],
                ':user_id' => $userId,
                ':post_id' => $postId,
            ]);

        if (empty($result)) {
            return (true);
        } else {
            $this->setStatus(AddLike::STATUS['ERROR_LIKE_EXISTS']);
            return (false);
        }
    }
}