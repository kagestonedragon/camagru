<?php

namespace Framework\Controllers\Posts;
use Framework\Controllers\Basic\Controller;
use Framework\Modules\Application;
use Framework\Helpers\Posts as PostsHelper;
use Framework\Modules\Debugger;

class GetList extends Controller
{
    const POSTS_MODEL = 'Posts@GetList';
    const COMMENTARIES_MODEL = "Posts@GetCommentaries";
    const LIKES_MODEL = "Posts@GetLikes";
    const POSTS_VIEW = 'Posts^ListRedesign';

    const USERS_MODEL = 'Users@GetList';
    const USERS_VIEW = 'Posts^Users';

    protected function process()
    {
        global $USER;

        if (!$USER->isAuthorized()) {
            Application::redirect('/auth/');
        }

        Application::loadHeader(SITE_DEFAULT_TEMPLATE);
        Application::loadView(GetList::POSTS_VIEW, $this->getFullPosts());
        Application::loadView(GetList::USERS_VIEW, $this->getUsersList());
        Application::loadFooter(SITE_DEFAULT_TEMPLATE);
    }

    private function getUsersList()
    {
        global $dbTables;

        $result = Application::loadModel(
            GetList::USERS_MODEL, [
                'TABLE_USERS' => $dbTables['USERS'],
                'LIMIT' => 10,
            ]
        );
        return ($result);
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