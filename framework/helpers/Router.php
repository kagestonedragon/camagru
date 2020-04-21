<?php

namespace Framework\Helpers;

class Router
{
    public static function getRegExpUrl(string $url)
    {
        $url = '/^' . str_replace('/', '\/', $url) . '$/';

        return ($url);
    }
}