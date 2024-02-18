<?php

$router = new Apps_Libs_Router();
$account = trim($router->getPOST('account'));
$password = trim($router->getPOST('password'));
$identtity = new Apps_Libs_UserIdentity();

if($identtity->isLogin()){
    $router->homePage();
}

if($router->getPOST("submit")){
    
$account = trim($router->getPOST('account'));
$password = trim($router->getPOST('password'));
    $identtity->username = $account;
    $identtity->password = $password;
    if($identtity->login()){
        $router->homePage();
    }else{
        echo "username or password is incorrect!";
    }
}

?>

<html>
    <head>
        <title>Dang nhap</title>
        <link rel="stylesheet" type="text/css" href="Login.css">
        <script>
            function validateAll(output) {
                console.log("Go to here");
                const account = document.getElementsByTagName('account').value;
                const password = document.getElementsByTagName('password').value;
                let errorMsg = "";

                if (account == "" || password == "") {
                    errorMsg = "Vui long nhap ten dang nhap va mat khau.";
                }
                if (errorMsg){
                    document.getElementById(output).innerHTML = errorMsg;
                    return false;
                }

                return true;
            }
        </script>
    </head>
    <body>
        <div class="nen">
            <img class="logo" src="./Hinh/Logo2.jpg" alt="Logo">
            <div class="dang-nhap">
                <form action="<?php echo $router->createUrl('login')?>" method="POST" onsubmit="return validateAll('validateResult');">
                    <br>
                    <p>Ten dang nhap</p>
                    <input class="text-box" type="text" name="account"><br>
                    <p>Mat khau</p>
                    <input class="text-box" type="password" name="password"><br>
                    <p id="validateResult"> </p>
                    <input class="btn" type="submit" name="submit" value="Dang nhap">
                </form>
            </div>
            <div class="cuahang">
                <a href="<?= str_replace("Admin","Public",$router->createUrl("Home"))?>">Quay lai cua hang</a>
            </div>
        </div>
    </body>
</html>