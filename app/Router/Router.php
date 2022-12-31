<?php

class Router
{
    public function route($uri)
    {
        $uri = $this->stripParameters($uri);

        switch ($uri) {
            case '':
            case 'home' :
                require __DIR__ . "/../controllers/HomeController.php";
                $controller = new HomeController();
                $controller->displayHomePage();
                break;
            case 'home/login':
                require __DIR__ . '/../controllers/LoginController.php';
                $controller = new LoginController();
                $controller->displayLoginPage();
                break;

            case 'home/about':
                require __DIR__ . '/controllers/homecontroller.php';
                $controller = new HomeController();
                $controller->about();
                break;
            case 'home/myAds':
                require __DIR__ . '/../controllers/MyAdsController.php';
                $controller = new MyAdsController();
                $controller->displayMyAdsPage();
                break;
            case 'api/adsapi';
                require __DIR__ . '/../API/Controllers/AdsController.php';
                $controller = new AdsController();
                $controller->index();
                break;
            case 'api/adsbyloggeduser';
                require __DIR__ . '/../API/Controllers/AdsController.php';
                $controller = new AdsController();
                $controller->sendAdsByLoggedUser();
                break;
            default:
                http_response_code(404);
                break;
        }

    }

    private function stripParameters($uri)
    {
        if (str_contains($uri, '?')) {
            $uri = substr($uri, 0, strpos($uri, '?'));
        }
        return $uri;
    }
}