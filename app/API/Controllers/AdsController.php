<?php
require __DIR__ . '/../../Services/AdService.php';
require_once __DIR__ . '/../../Models/Ad.php';
require_once __DIR__ . '/../../Models/User.php';

class AdsController
{
    private $adService;

    public function __construct()
    {
        $this->adService = new AdService();
    }

    public function index()
    {
            $this->sendHeaders();

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

    public function updateAdRequest(): void
    {
        $responseData="";
        $this->sendHeaders();
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $body = file_get_contents('php://input');
            $data = json_decode($body);
            if($data->OperationType=="ChangeStatusOfAd"){
                error_clear_last();
                $this->adService->updateStatusOfAd(Status::from($data->adStatus),$data->adID);
                // checking if are triggered or not
                $responseData=$this->getResponseMessage(error_get_last()); // setting error according to error

            }
            else if ($data->OperationType== "DeleteAd"){
                error_clear_last();
                $this->adService->deleteAd($data->adID,$data->imageURI);
               $responseData=$this->getResponseMessage(error_get_last()); // setting error according to error
            }
            echo json_encode($responseData);
        }
    }

    public function sendAdsByLoggedUser(): void
    {
        $this->sendHeaders();

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $body = file_get_contents('php://input');
            $data = json_decode($body);
            $loggedUserId = $data->loggedUserId;
            $user = new User();
            $user->setId($loggedUserId);
            $ads = $this->adService->getAdsByLoggedUser($user);//already had method so just making user object and setting id only
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
    private function getResponseMessage($error):mixed{
        if($error!==null){
            $errorMessage=$error['message'];
            $responseData = array(
                "success" => false,
                "message" => "$errorMessage"
            );
        }
        else{
            $responseData = array(
                "success" => true,
                "message" => ""
            );
        }
        return $responseData;
    }

    private function sendHeaders(): void
    {
        header('X-Powered-By: PHP/8.1.13');
        header("Pragma: no-cache");
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Headers: *");
        header("Access-Control-Allow-Methods: *");
        header("Cache-Control: no-store, no-cache, must-revalidate");
        header('Content-Type: application/json');
    }
}