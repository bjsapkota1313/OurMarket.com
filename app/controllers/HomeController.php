<?php
require __DIR__ . "/../Models/User.php";
require __DIR__ ."/../Models/Ad.php";
require __DIR__ ."/../Services/AdService.php";

class HomeController
{
     private $adService;

    public function __construct()
    {
        $this->adService=new AdService();
    }
    public function displayHomePage()
    {
        $ads=$this->adService->getAllAvailableAds(Status::Available); // only showing available ads
        require __DIR__ . "/../Views/HomePage/Home.php";
        include_once __DIR__.'/../Views/Footer.php';
        $this->showAvailableAds($ads);
        $this->loginAndSignout();
    }
    private function loginAndSignout(): void
    {
        if (isset($_SESSION["loggedUser"])) {
            echo '<script>             
                disableLoginButton();
                </script>';
        }
        if (isset($_POST["btnSignOut"])) {
            //session_destroy();
            unset($_SESSION["loggedUser"]);
            echo '<script>
              enableLogin();
                </script>';
        }
    }
    private function showAvailableAds($ads) :void{
        if(is_null($ads)){
            echo '<script>displayInformativeMessage()</script>';
        }
        else{
            require __DIR__.'/../Views/HomePage/ShowAvailableAds.php';
        }
    }

}