<?php
class HomeController{

    public function __construct()
    {
    }
    public function displayHomePage(){
        require __DIR__ . "/../Views/pages/Home.php";
    }
}