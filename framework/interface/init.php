<?php

/**
 * Запускаем сессию
 */
session_start();

/**
 * Автолоадер
 */
require_once($_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php');
require_once('include/autoloader.php');


/**
 * Константы
 */
require_once('include/constants/dotenv.php');
require_once('include/constants/framework.php');
require_once('include/constants/site.php');

/**
 * Конфигурации
 */
require_once('include/config/database.php');
require_once('include/config/tables.php');

/**
 * Создание объектов модулей
 */
require_once('include/global_object.php');
