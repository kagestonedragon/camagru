<?php

$envpath = $_SERVER['DOCUMENT_ROOT'] . '/..';
(Dotenv\Dotenv::createImmutable($envpath))->load();

function env(string $key) {
	return (getenv($key));
}
