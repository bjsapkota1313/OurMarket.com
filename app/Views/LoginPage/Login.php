<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet"href="/CSS/LoginStyles.css">
</head>
<body class="text-center bg-dark">

<main class="form-signin w-100 m-auto" id="loginForm">
    <form  method="POST">
        <a href="/home"><img class="mb-4" src="/img/Logo.svg" alt="BusinessLogo" width="250" height="80"></a>
        <h1 class="h3 mb-3 fw-bold">Log In</h1>

        <div class="form-floating">
            <input type="email" class="form-control" id="floatingInput" placeholder="name@example.com" name="email" required>
            <label for="floatingInput">Email address</label>
        </div>
        <div class="form-floating">
            <input name="password" type="password" class="form-control" id="floatingPassword" placeholder="Password"  required>
            <i class="fa fa-eye" data-toggle="password-toggle" data-target="#password"></i>
            <label for="floatingPassword">Password</label>
        </div>

        <div id="rememberMe" class="checkbox mb-4 color-primary">
            <label id="labelRememberMe">
                <input type="checkbox" value="1" name="remember_me"> Remember me</label>
        </div>
        <button class="w-100 btn btn-lg btn-success" type="submit" name="btnLogin" >Log in</button>
        <p class="mt-5 mb-3 text-muted"> &#169;OurMarket.com</p>
    </form>
</main>
<script src="/Javascripts/Login.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4"
        crossorigin="anonymous"></script>
</body>
</html>