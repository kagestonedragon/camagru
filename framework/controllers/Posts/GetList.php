<?php

namespace Framework\Controllers\Posts;
use Framework\Controllers\Basic\Controller;
use Framework\Modules\Application;
use Framework\Helpers\Posts as PostsHelper;

class GetList extends Controller
{
    const POSTS_MODEL = 'Posts@GetList';
    const COMMENTARIES_MODEL = "Posts@GetCommentaries";
    const LIKES_MODEL = "Posts@GetLikes";
    const VIEW = 'Posts^List';

    protected function process()
    {
        global $USER;
        
        if (!$USER->isAuthorized()) {
            Application::redirect('/auth/');
        }

        Application::loadHeader(SITE_DEFAULT_TEMPLATE);
        Application::loadView(GetList::VIEW, $this->getFullPosts());
        Application::loadFooter(SITE_DEFAULT_TEMPLATE);
    }

    private function getFullPosts()
    {
        global $dbTables;
        global $USER;

        // Получаем информация о постах
        $result = Application::loadModel(
            GetList::POSTS_MODEL,
            [
                'TABLE_POSTS' => $dbTables['POSTS'],
                'TABLE_USERS' => $dbTables['USERS'],
                'TABLE_CONNECTION' => $dbTables['USERS_POSTS'],
            ]
        );

        $postIds = array_column($result["ITEMS"], 'id');

        // Получаем комментарии для постов
        $result['COMMENTARIES'] = Application::LoadModel(
            GetList::COMMENTARIES_MODEL,
            [
                'TABLE_COMMENTARIES' => $dbTables['COMMENTARIES'],
                'TABLE_USERS' => $dbTables['USERS'],
                'TABLE_CONNECTION' => $dbTables['USERS_POSTS_COMMENTARIES'],
                'POST_IDS' => $postIds,
            ]
        );

        // Получаем лайки для постов
        $likes = Application::loadModel(
            GetList::LIKES_MODEL,
            [
                'TABLE_CONNECTION' => $dbTables['USERS_POSTS_LIKES'],
                'POST_IDS' => $postIds,
            ]
        );

        // Проставляем действие на пост (лайк / дизлайк)
        PostsHelper::setLikeActions($result['ITEMS'], $likes, $USER->getId());

        return ($result);
    }
}