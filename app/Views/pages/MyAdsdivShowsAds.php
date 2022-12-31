
<div class="container ml-2" id="myAdsContainer">
    <?php
    foreach ($loggedUserAds
    as $ad) {
        if($ad->getStatus()===Status::Available){
    ?>
    <div class="card mb-3" style="max-width: 900px;">
        <div class="row g-0">
            <div class="col-md-4 col-xl-4">
                <img src="<?= $ad->getImageUri() ?>" class="img-fluid rounded-start" >
            </div>
            <div class="col-md-8 col-xl-8 d-flex flex-column justify-content-around">
                <div class="card-body">
                    <h5 class="card-title"><?= $ad->getProductName() ?></h5>
                    <p class="card-text"><?= $ad->getDescription() ?></p>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item"><strong>Price:</strong> €<?= number_format($ad->getPrice(), 2, '.') ?></li>
                        <li class="list-group-item"><strong>Status:</strong> <?= $ad->getStatus()->value?></li>
                        <li class="list-group-item"><strong>Posted at: </strong><?= $ad->getPostedDate() ?></li>

                    </ul>
                </div>
                <div class="d-flex justify-content-end mb-2">
                    <form method="POST" >
                        <input type="text" value="<?= $ad->getId()?>"  name="adIdHidden" id="adIdHidden"  hidden>
                        <input type="submit" class="btn btn-primary mx-2" id="btnMarkAsSold" name="btnMarkAsSold" id="btnMarkAsSold" value="Mark As Sold">
                        <button class="btn btn-secondary mx-2" ><i class="fa-solid fa-file-pen"></i> Edit</button>
                        <input type="submit" class="btn btn-danger mx-2" id="btnDeleteAd" name ="btnDeleteAd" value="&#xf1f8; Delete">
                    </form>
                </div>
            </div>
        </div>
    </div>
        <?php
         } else{
    ?>
            <div class="card mb-3" style="max-width: 900px; position: relative;">
                <div class="row g-0">
                    <div class="col-md-4 col-xl-4">
                        <img src="<?= $ad->getImageUri() ?>" class="img-fluid rounded-start" alt="...">
                    </div>
                    <div class="col-md-8 col-xl-8 d-flex flex-column justify-content-around">
                        <div class="card-body">
                            <h5 class="card-title"><?= $ad->getProductName() ?></h5>
                            <p class="card-text"><?= $ad->getDescription() ?></p>
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item"><strong>Price:</strong> €<?= number_format($ad->getPrice(), 2, '.') ?></li>
                                <li class="list-group-item"><strong>Status:</strong> <?= $ad->getStatus()->value?></li>
                                <li class="list-group-item"><strong>Posted at: </strong><?= $ad->getPostedDate() ?></li>
                            </ul>
                        </div>
                        <div class="d-flex justify-content-end mb-2">
                            <button class="btn btn-primary mx-2" disabled>Mark As Sold</button>
                            <button class="btn btn-secondary mx-2" disabled><i class="fa-solid fa-file-pen"></i> Edit</button>
                            <button class="btn btn-danger mx-2" disabled><i class="fa-solid fa-trash"></i> Delete</button>
                        </div>
                    </div>
                </div>
                <div class="overlay" style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background-color: rgba(0,0,0,0.5); display: flex; align-items: center; justify-content: center;">
                    <h2 style="color: white;"><?= $ad->getStatus()->value?></h2>
                </div>
            </div>


        <?php }}?>
</div>
<script src="/Javascripts/Ad.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4"
        crossorigin="anonymous"></script>
</body>
</html>