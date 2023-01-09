<?php
require __DIR__ . "/../Models/User.php";
require __DIR__ ."/../Models/Ad.php";
require __DIR__ ."/../Services/AdService.php";
class MyAdsController
{
    private $adService;
    private $loggedUser;
    public function __construct()
    {
        $this->adService=new AdService();
        $this->loggedUser=$this->GetLoggedUser();
    }
    public function displayMyAdsPage():void {
        $displayMessage=$this->displayInfo();
        require __DIR__ . '/../Views/MyAdsPage/MyAds.php';
        $this->showAds();
        include_once __DIR__.'/../Views/Footer.php';
        $this->loginAndSignout();

    }
    private function displayInfo() :string{
        $currentHour = (int) date('G');  // Get the current hour as an integer
            $greet="";
        if ($currentHour < 12) {
            $greet= "Good Morning";
        } elseif ($currentHour < 18) {
            $greet= "Good Afternoon";
        } else {
            $greet= "Good Evening";
        }
        if(is_null($this->loggedUser))  {
            $displayMessage="Please,login in order to view,edit or post an Ad";
        }
        else{
            $loggedUser=$this->getLoggedUser();
            $displayMessage=$greet .", ".$loggedUser->getFirstName();
        }
        return $displayMessage;
    }
    private function loginAndSignout(): void
    {
        if (!is_null($this->loggedUser)) {
            echo '<script>             
                disableLoginButton();
                showPostNewAd();
                </script>';
        }
        else{
            echo '<script>
              hidePostNewAd();
                </script>';
        }
        if (isset($_POST["btnSignOut"])) {
            unset($_SESSION["loggedUser"]);
            echo '<script>
              enableLogin();
              hidePostNewAd();
              loginMessageForSignOut();
              clearScreen();
                </script>';
        }
    }
    private function GetLoggedUser(){
        if (isset($_SESSION["loggedUser"])) {
            return unserialize(serialize($_SESSION["loggedUser"]));
        }
        else{
            return null;
        }
    }
    private function showAds(){

        if (!is_null($this->loggedUser)) {
            if (!is_null($this->adService->getAdsByLoggedUser($this->loggedUser))) {
                $loggedUserAds = $this->adService->getAdsByLoggedUser($this->loggedUser);
                require __DIR__ . '/../Views/MyAdsPage/EditAdsModal.php';
                require __DIR__ . '/../Views/MyAdsPage/MyAdsdivShowsAds.php';
            } else {
                echo "No ads";
            }
        }

    }
}