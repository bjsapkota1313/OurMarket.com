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

    public function index(): void
    {
        $this->sendHeaders();

        // Respond to a POST request to /api/article
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $responseData = array();
            $adDetails = json_decode($_POST['adDetails'], true);
            $username = htmlspecialchars($adDetails['loggedUserName']);
            $productName = htmlspecialchars($adDetails['productName']);
            $productPrice=htmlspecialchars($adDetails['price']);
            $productDescription=htmlspecialchars($adDetails['productDescription']);
            // Process the image file
            $image = $_FILES['image'];
            $responseData = $this->processImage($image);

            if ($responseData['success']) {
                $imageTempName = $image['tmp_name'];
                $imageName = $image['name'];
                $targetDirectory = "img/";
                $imageExtension = explode('.', $imageName);
                $newImageName = "OurMarket". "-" . date("Y-m-d") ."-".time(). "-" . $username . "." . end($imageExtension); // making each file unique by renaming it
                //when everything is correct
                $this->adService->postNewAd($this->createAd($productName, $productPrice,$productDescription , "/" . $targetDirectory . $newImageName, $adDetails['loggedUserId']));
                move_uploaded_file($imageTempName, $targetDirectory . $imageName);
                rename($targetDirectory . $imageName, $targetDirectory . $newImageName);
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

    public function handleAdEditRequest(): void
    {
        $this->sendHeaders();
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $responseData = array();
            $editedAdDetails = json_decode($_POST['editedAdDetails'], true);
            $productName = htmlspecialchars($editedAdDetails['productName']);
            $productPrice = htmlspecialchars($editedAdDetails['price']);
            $productDescription = htmlspecialchars($editedAdDetails['productDescription']);
            $adID = htmlspecialchars($editedAdDetails["adId"]);
            // Process the image file
            $image = $_FILES['inputImage'];
            // Validate the image file
            $responseData=$this->processImage($image);
            if ($responseData['success']) {
                error_clear_last();
                $this->adService->editAdWithNewDetails($image,$productName,$productDescription,$productPrice,$adID);
                $responseData=$this->getResponseMessage(error_get_last());

            } else {
                $responseData = array(
                    "success" => false,
                    "message" => "Something went Wrong while Processing image"
                );
            }
            echo json_encode($responseData);
        }

    }

    public function operateAdRequest(): void
    {
        $responseData = "";
        $this->sendHeaders();
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $body = file_get_contents('php://input');
            $data = json_decode($body);
            if (htmlspecialchars($data->OperationType) == "ChangeStatusOfAd") {
                error_clear_last();
                $this->adService->markAdAsSold(htmlspecialchars($data->adID));
                // checking if are triggered or not
                $responseData = $this->getResponseMessage(error_get_last()); // setting error according to error

            } else if (htmlspecialchars($data->OperationType) == "DeleteAd") {
                error_clear_last();
                $this->adService->deleteAd(htmlspecialchars($data->adID), htmlspecialchars($data->imageURI));
                $responseData = $this->getResponseMessage(error_get_last()); // setting error according to error
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
            $loggedUserId = htmlspecialchars($data->loggedUserId);
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

    private function getResponseMessage($error): mixed
    {
        if ($error !== null) {
            $errorMessage = $error['message'];
            $responseData = array(
                "success" => false,
                "message" => "$errorMessage"
            );
        } else {
            $responseData = array(
                "success" => true,
                "message" => ""
            );
        }
        return $responseData;
    }

    function processImage($image)
    {
        if ($image['error'] == UPLOAD_ERR_OK) {
            $imageType = $image['type'];

            // Validate the image file
            $allowedTypes = ['image/jpeg', 'image/png', 'image/jpg'];
            if (!in_array($imageType, $allowedTypes)) {
                return array(
                    "success" => false,
                    "message" => "This type of image file are not accepted"
                );
            } else {
                return array(
                    "success" => true,
                    "message" => ""
                );
            }
        } else {
            return array(
                "success" => false,
                "message" => "Something went Wrong while uploading image"
            );
        }
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