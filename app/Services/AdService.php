<?php
require __DIR__. '/../repositories/AdRepository.php';
require_once __DIR__. '/../Models/User.php';
require_once __DIR__."/../Models/Ad.php";
class AdService
{
    private AdRepository $adRepository;
    public function __construct()
    {
        $this->adRepository = new AdRepository();
    }
    public function getAllAvailableAds(Status $status){
        return $this->adRepository->getAllAvailableAds( $status);
    }
    public function getAdsByLoggedUser($loggedUser){
        return $this->adRepository->getAdsByLoggedUser($loggedUser);
    }
    public function postNewAd(Ad $ad){
        $this->adRepository->postNewAd($ad);
    }
    public function updateStatusOfAd($status, $adID){
        $this->adRepository->updateStatusOfAd($status, $adID);
    }
    public function deleteAd($adID, $imageFile){
        $this->adRepository->deleteAd($adID, $imageFile);
    }
    public function markAdAsSold($adId){
        //Marking as sold as did not want to show the status of ad passing as string from javascript
        $this->updateStatusOfAd(status::Sold,$adId);
    }
    public function editAdWithNewDetails($newImage,$productName,$description,$price,$adID){
        $this->adRepository->editAd($newImage,$productName,$description,$price,$adID);
    }

}