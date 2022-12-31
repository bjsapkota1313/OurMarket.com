<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Home</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/22097c36aa.js" crossorigin="anonymous"></script>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark bg-info p-3">
    <div class="container-fluid">
        <a class="navbar-brand"><img src="/img/Logo.svg" alt="BusinessLogo"
                                     width="200" height="40">
        </a>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown"
                aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class=" collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav ms-auto ">
                <li class="nav-item">
                    <a class="nav-link mx-2 active" aria-current="page" href="#">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link mx-2" href="/home/myAds">My Ads</a>
                </li>
            </ul>
            <ul class="navbar-nav ms-auto  d-lg-inline-flex">
                <li class="nav-item">
                    <a class="nav-link mx-2" href="">
                        <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="white" class="bi bi-cart"
                             viewBox="0 0 16 16">
                            <path d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .491.592l-1.5 8A.5.5 0 0 1 13 12H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5zM3.102 4l1.313 7h8.17l1.313-7H3.102zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm-7 1a1 1 0 1 1 0 2 1 1 0 0 1 0-2zm7 0a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
                        </svg>
                    </a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link mx-2 dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button"
                       data-bs-toggle="dropdown" aria-expanded="false">
                        <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="White" class="bi bi-person"
                             viewBox="0 0 16 16">
                            <path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6Zm2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0Zm4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4Zm-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664h10Z"/>
                        </svg>
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                        <li><a id="loginLink" class="dropdown-item" href="/home/login">Login</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <form method="POST">
                                <button class="dropdown-item" name="btnSignOut" id="signOut" type="submit"
                                        value="Sign Out" disabled="true">Sign out
                                </button>
                            </form>
                        </li>
                    </ul>
                </li>

            </ul>
        </div>
    </div>
</nav>
<div class="container-fluid" style="background-color: aliceblue">
    <div class="container py-3 mx-auto">
        <form role="search">
            <input class="form-control" type="search" placeholder="Search in Our Market" aria-label="Search"
                   style="border-color: black">
        </form>
    </div>
</div>
<div class="container">
    <div class="row py-3 text-center">
        <?php
        foreach ($ads
        as $ad) {
        ?>
        <div class="col-md-4 col-sm-12 col-xl-3 my-3">
            <div class="card h-100 shadow">
                <img src="<?= $ad->getImageUri() ?>" class="img-fluid card-img-top" alt="<?= $ad->getProductName() ?>"
                     style="width:300px; height:300px">
                <div class="card-body">
                    <h3 class="card-title"><?= $ad->getProductName()?></h3>
                    <p class="card-text"><?= $ad->getDescription() ?></p>
                    <button class="btn btn-primary position-relative" type="submit"><i class="fa-solid fa-cart-plus"></i>
                        €<?= number_format($ad->getPrice(), 2, '.') ?> </button>
                </div>
                <div class="card-footer ">
                    <p class="card-text"><small class="text-muted"><?= $ad->getPostedDate() ?> posted by
                            <strong><?= $ad->getUser()->getFirstName() ?></strong></small></p>
                </div>
            </div>
        </div>
            <?php
            }
            ?>

    </div>
    <script src="/Javascripts/Ad.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4"
            crossorigin="anonymous"></script>
</body>
</html>


