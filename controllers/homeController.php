<?php

require "models/databaseModel.php";
require "models/jwt.php";

if (isset($_COOKIE["auth_token"])) {
    echo $_COOKIE["auth_token"];
    $jwtHelper = new JWT();
    $jwt = $jwtHelper->decode($_COOKIE["auth_token"]);
    if ($jwt) {
        var_dump($jwt);
    } else {
        echo "Invalid token.";
    }
    
} else {
    echo "you must be logged in <a style='color: blue;' href='/register'>register there</a>";
}


require "views/header.php";
require "views/homeView.php";
require "views/footer.php";