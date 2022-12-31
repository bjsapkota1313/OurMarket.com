<?php
require __DIR__ . '/../../Services/AdService.php';
require_once __DIR__ . '/../../Models/Ad.php';
require_once __DIR__.'/../../Models/User.php';

class AdsController
{
    private $adService;

    public function __construct()
    {
        $this->adService = new AdService();
    }

    public function index()
    {
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Headers: *");
        header("Access-Control-Allow-Methods: *");
        header('Content-Type: application/json');
        // Respond to a GET request to /api/article
        if ($_SERVER["REQUEST_METHOD"] == "GET") {

            header('Content-Type: application/json');
            $response = array('status' => 'success', 'message' => 'Your request was successful');
            //  echo json_encode($response);
            //  echo json_encode($articles);
            // your code here
            // return all articles in the database as JSON
            //$body = file_get_contents('php://input');
        }

        // Respond to a POST request to /api/article
        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            $responseData = array();
            $adDetails = json_decode($_POST['adDetails'], true);
            $username = $adDetails['loggedUserName'];
            $productName = $adDetails['productName'];
            // Process the image file
            $image = $_FILES['image'];
            if ($image['error'] == UPLOAD_ERR_OK) {
                $imageName = $image['name'];
                $imageType = $image['type'];
                $imageTempName = $image['tmp_name'];

                // Validate the image file
                $allowedTypes = ['image/jpeg', 'image/png'];
                if (!in_array($imageType, $allowedTypes)) {
                    $responseData = array(
                        "success" => true,
                        "message" => "This type of image file is not accepted"
                    );
                } else {
                    $targetDirectory = "img/";
                    $imageExtension = explode('.', $imageName);
                    $newImageName = $productName . "-" . date("Y-m-d") . "-" . $username . "." . end($imageExtension);
                    //when everything is correct
                    $this->adService->postNewAd($this->createAd($adDetails['productName'], $adDetails['price'], $adDetails['productDescription'], "/" . $targetDirectory . $newImageName, $adDetails['loggedUserId']));
                    move_uploaded_file($imageTempName, $targetDirectory . $imageName);
                    rename($targetDirectory . $imageName, $targetDirectory . $newImageName);
                    $responseData = array(
                        "success" => true,
                        "message" => "The form data was processed successfully"
                    );
                }
            } else {
                $responseData = array(
                    "success" => false,
                    "message" => "Something went Wrong while uploading image"
                );
            }

            // Convert the response message to a JSON string
            $responseJson = json_encode($responseData);

            // Send the response message as the body of the HTTP response
            echo $responseJson;

        }

    }

    public function sendAdsByLoggedUser(): void
    {
        header('X-Powered-By: PHP/8.1.13');
        header("Pragma: no-cache");
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Headers: *");
        header("Access-Control-Allow-Methods: *");
        header("Cache-Control: no-store, no-cache, must-revalidate");
        header('Content-Type: application/json');


        if($_SERVER["REQUEST_METHOD"] == "GET"){
            $user= new User();
            $user->setId(1);
            $ads=$this->adService->getAdsByLoggedUser($user);//already had method so just making user object and setting id only

            echo json_encode($ads);
         }
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $body = file_get_contents('php://input');
            $data = json_decode($body);
            $loggedUserId=$data->loggedUserId;
            $user= new User();
            $user->setId($loggedUserId);
            $ads=$this->adService->getAdsByLoggedUser($user);//already had method so just making user object and setting id only
            echo json_encode($ads);
        }
    }

    private function createAd($name, $price, $description, $imageURI, $userID): Ad
    {
        $ad = new Ad();
        $ad->setProductName($name);
        $ad->setPrice($price);
        $ad->setDescription($description);
        $ad->getUser()->setId($userID);
        $ad->setImageUri($imageURI);
        return $ad;
    }

}