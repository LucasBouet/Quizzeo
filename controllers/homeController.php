<?php

require "models/databaseModel.php";
require "models/jwt.php";

if (isset($_COOKIE["auth_token"])) {
    echo $_COOKIE["auth_token"];
    $jwtHelper = new JWT();
    $jwt = $jwtHelper->decode($_COOKIE["auth_token"]);
    var_dump($jwt);
} else {
    echo "you must be logged in"
}


require "views/header.php";
require "views/homeView.php";
require "views/footer.php";