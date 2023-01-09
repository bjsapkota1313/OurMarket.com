<?php
require __DIR__ . ' /../Services/UserService.php';
class LoginController
{
    private $userService;

    public function __construct()
    {
        $this->userService = new UserService();
    }

    public function displayLoginPage()
    {
        require __DIR__ . "/../Views/LoginPage/Login.php";

        if (isset($_POST["btnLogin"])) {
            $email = htmlspecialchars($_POST["email"]);
            $password = htmlspecialchars($_POST["password"]);
            $loggingUser = $this->userService->verifyAndGetUser($email, $password);
            if (is_null($loggingUser)) {
                echo ' <Script>

     function showLoginFailed(){
        const currentDiv=document.getElementById("rememberMe");
        var newDiv=document.createElement("div");
        newDiv.className="alert-danger";
        newDiv.style.color="red";
        newDiv.innerHTML="Incorrect Details";
        currentDiv.append(newDiv);
    }
 showLoginFailed();
    </Script>';
            } else {
                $_SESSION["loggedUser"] = $loggingUser;
                echo "<script>location.href = '/home/myAds'</script>";
            }
        }

    }

}