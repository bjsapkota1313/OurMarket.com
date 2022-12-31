<?php
require __DIR__ . '/../Router/router.php';

$uri = trim($_SERVER['REQUEST_URI'], '/');
session_start();

$router = new Router();
$router->route($uri);