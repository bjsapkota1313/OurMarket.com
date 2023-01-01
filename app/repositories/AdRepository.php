<?php
require_once __DIR__ . "/../Models/Ad.php";
require_once __DIR__ . "/../Models/User.php";
require_once __DIR__ . "/Repository.php";
require_once __DIR__ . "/UserRepository.php";
require_once __DIR__ . "/../Models/Status.php";

class AdRepository extends Repository
{
    private $userRepo;

    public function __construct()
    {
        parent::__construct();
        $this->userRepo = new UserRepository();
    }

    public function getAllAvailableAds(Status $status)
    {
        try {

            $stmt = $this->connection->prepare("SELECT id,productName,description,postedDate,price,imageURI,userID,status From Ads WHERE status=:status");
            $label = $status->label();
            $stmt->bindParam(":status", $label);
            if ($this->checkAdinDB($stmt)) {
                $stmt->execute();
                $result = $stmt->fetchAll();
                $ads = array();
                foreach ($result as $row) {
                    $ads[] = $this->readOneAd($row);
                }
                return $ads;
            }
            return null;
        } catch (PDOException  $e) {
            echo $e;
        }
    }

    public function getAdsByLoggedUser($loggedUser)
    {
        try {
            $stmt = $this->connection->prepare("SELECT id,productName,description,postedDate,price,imageURI,userID,status From Ads WHERE UserID= :userID");
            $id = $loggedUser->getId();
            $stmt->bindParam(":userID", $id);
            if ($this->checkAdinDB($stmt)) {
                $stmt->execute();
                $result = $stmt->fetchAll();
                $ads = array();
                foreach ($result as $row) {
                    $ads[] = $this->readOneAd($row);
                }
                return $ads;
            }
            return null;
        } catch (PDOException $e) {
            echo $e;
        }
    }

    public function updateStatusOfAd($status, $adID)
    {
        try {
            $stmt = $this->connection->prepare("UPDATE Ads SET status= :status WHERE id= :adId");
            $stmt->bindValue(":status", $status->label());
            $stmt->bindValue(":adId", $adID);

            if ($stmt->execute()) {
                $rows_updated = $stmt->rowCount();
                if ($rows_updated <= 0) {
                   trigger_error(" Ad couldn't be Updated Please,Try again", E_USER_ERROR);

                }
            }
        } catch (PDOException | Exception $e) {
            trigger_error("An error occurred: " , E_USER_ERROR);
        }

    }

    public function deleteAd($adID, $imageURI)
    {
        try {
            $stmt = $this->connection->prepare("DELETE FROM Ads  WHERE id= :adId");
            $stmt->bindValue(":adId", $adID);
            if ($stmt->execute()) {
                $rows_updated = $stmt->rowCount();
                if ($rows_updated > 0) {
                    // delete the file if the database query was successful
                    $imageFile=__DIR__.'/../public'.$imageURI;
                    unlink($imageFile);
                } else {
                    trigger_error(" Ad couldn't be deleted", E_USER_ERROR);
                }
            }
        } catch (PDOException| Exception   $e) {
            trigger_error("An error occurred: " . $e->getMessage(), E_USER_ERROR);
        }
    }

    private function readOneAd($dBRow): Ad
    {
        $ad = new Ad();
        $ad->setId($dBRow["id"]);
        $ad->setDescription($dBRow["description"]);
        $ad->setPostedDate($dBRow["postedDate"]);
        $ad->setPrice($dBRow["price"]);
        $ad->setProductName($dBRow["productName"]);
        $ad->setImageUri($dBRow["imageURI"]);
        $ad->setStatus(Status::from($dBRow["status"]));
        $ad->setUser($this->userRepo->getUserById($dBRow["userID"]));
        return $ad;
    }

    private function checkAdinDB($stmt): bool
    {
        try {
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                return true;
            }
            return false;
        } catch (PDOException $e) {
            echo $e;
        }
    }

    public function postNewAd(Ad $ad)
    {
        try {
            $stmt = $this->connection->prepare("INSERT INTO Ads( productName, description,  price, userID, imageURI) VALUES (:productName,:description,:price,:userID,:imageURI)");
            $stmt->bindValue(":productName", $ad->getProductName());
            $stmt->bindValue(":description", $ad->getDescription());
            $stmt->bindValue(":price", $ad->getPrice());
            $stmt->bindValue(":userID", $ad->getUser()->getId());
            $stmt->bindValue(":imageURI", $ad->getImageUri());
            $stmt->execute();
        } catch (PDOException $e) {
            echo $e;
        }
    }
}