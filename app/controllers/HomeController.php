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
        $ads=$this->adService->getAllAvailableAds(Status::Available); // only showing avaialble ads
        require __DIR__ . "/../Views/pages/Home.php";
        $this->loginAndLogout();
        if(is_null($ads)){
            echo"<H2> No products are in sale</H2>";
        }
    }
    private function loginAndLogout(): void
    {
        if (isset($_SESSION["loggedUser"])) {
           // $loggedUser = unserialize(serialize($_SESSION["loggedUser"]));
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

}