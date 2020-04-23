<?php

namespace Framework\Modules;
use Framework\Helpers\Router as RouterHelper;

class Router
{
    public string $location = '';

    public static function route(string $method, string $url, string $controller, array $params = [])
    {
        if ($_SERVER['REQUEST_METHOD'] == strtoupper($method)) {
            if (preg_match(RouterHelper::getRegExpUrl($url), $_SERVER['REQUEST_URI'], $matches)) {
                self::setParams($params, $matches);
                Application::loadController($controller);
                Application::renderPage();
            }
        }
    }

    private static function setParams(array $params, array $matches)
    {
        global $REQUEST;

        foreach ($params as $key => $value) {
            if (isset($matches[$value])) {
                $REQUEST->arGet[$key] = $matches[$value];
            } else {
                $REQUEST->arGet[$key] = $value;
            }
        }
    }
}