<?php
require __DIR__ . '/../Router/router.php';

$uri = trim($_SERVER['REQUEST_URI'], '/');
// destroying
session_set_cookie_params(0);
session_start();

$router = new Router();
$router->route($uri);