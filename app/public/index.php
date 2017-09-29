<?php
defined('APPLICATION_PATH') || define('APPLICATION_PATH', __DIR__ . '/..');

require '../autoloader.php';

Api\Autoloader::register();

$app = new Api\Application();
$request = $app->handleRequest();