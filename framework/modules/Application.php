<?php

namespace Framework\Modules;

use Framework\Helpers\Application as AppHelper;

/**
 * Class Application
 * @package Framework\Modules
 * 1. Вынести редирект в отдельный модуль ($request)
 */
class Application
{
    private static string $header = '';
    private static string $page = '';
    private static string $footer = '';

    /**
     * Подключение модели
     * @noinspection PhpUndefinedMethodInspection
     * @param string $model
     * @param array $params
     * @return array
     */
    public static function loadModel(string $model, array $params = [])
    {
        $modelNamespace = AppHelper::getModelNamespace($model);

        return (
            (new $modelNamespace($params))->getResult()
        );
    }

    /**
     * Подключение view (шаблона)
     * @noinspection PhpIncludeInspection
     * @param string $view
     * @param array $result
     */
    public static function loadView(string $view, array $result = [])
    {
        if (empty(self::$header)) {
            require_once(AppHelper::getViewPath($view));
        } else {
            ob_start();
            require_once(AppHelper::getViewPath($view));
            self::$page .= ob_get_contents();
            ob_end_clean();
        }
    }

    /**
     * Подключение контроллера
     * @param string $controller
     * @param array $params
     */
    public static function loadController(string $controller, array $params = [])
    {
        $controllerNamespace = AppHelper::getControllerNamespace($controller);

        new $controllerNamespace($params);
    }

    public static function redirect(string $url)
    {
        header('Location: ' . $url);
        die();
    }

    /**
     * Подключение хедера шаблона
     * @noinspection PhpIncludeInspection
     * @param string $template
     */
    public static function loadHeader(string $template)
    {
        ob_start();
        require_once(AppHelper::getHeaderPath($template));
        self::$header .= ob_get_contents();
        ob_end_clean();
    }

    /**
     * Подключение футера шаблона
     * @noinspection PhpIncludeInspection
     * @param string $template
     */
    public static function loadFooter(string $template)
    {
        ob_start();
        require_once(AppHelper::getFooterPath($template));
        self::$footer .= ob_get_contents();
        ob_end_clean();
    }

    public static function renderPage()
    {
        echo self::$header;
        echo self::$page;
        echo self::$footer;
    }

    public static function attachJsScript(string $path)
    {
        if (!empty(self::$header)) {
            $path = str_replace($_SERVER['DOCUMENT_ROOT'], '', $path);
            $scriptTag = '<script src="' . $path . '"></script>';
            self::$header = str_replace('</head>', $scriptTag . '</head>', self::$header);
        }
    }

    public static function setPageTitle(string $title)
    {
        if (!empty(self::$header)) {
            $pattern = '/(<title>)(\S*)(<\/title>)/';
            $replace = '${1}' . $title . '${3}';
            self::$header = preg_replace($pattern, $replace, self::$header);
        }
    }

    public static function setAjaxResult($result)
    {
        self::$page = json_encode($result);
    }
}
