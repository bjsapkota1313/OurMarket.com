<?php
if (isset($_POST['remember_me']) && $_POST['remember_me'] == '1'))
{
    setcookie('username', $username, time() + (86400 * 30)); // 86400 = 1 day
    setcookie('password', $password, time() + (86400 * 30)); // 86400 = 1 day
}
if (isset($_COOKIE['username']) && isset($_COOKIE['password'])) {
    $username = $_COOKIE['username'];
    $password = $_COOKIE['password'];
}
if(isset($_POST['btnLogin'])){
    echo $_POST['email'];
}