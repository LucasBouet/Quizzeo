<?php

require "models/databaseModel.php";
require "models/jwt.php";
require "models/createModel.php";

if (isset($_COOKIE["auth_token"])) {
    $errors = [];
    $success = [];
    $jwtHelper = new JWT();
    $jwt = $jwtHelper->decode($_COOKIE["auth_token"]);
    if ($jwt) {
        $username = getUserFromId($jwt['body']['user_id'])['Username'];
        
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            
            if (isset($_POST['function']) && $_POST['function'] == 'deactivateUser') {
                $userId = $_POST['userId'];
                deactivateUser($userId);
                echo "<script>window.location.href = window.location.pathname;</script>";
                exit;
                
            } elseif (isset($_POST['function']) && $_POST['function'] == 'activateUser') {
                $userId = $_POST['userId'];
                activateUser($userId);
                echo "<script>window.location.href = window.location.pathname;</script>";
                exit;
                
            } elseif (isset($_POST['function']) && $_POST['function'] == 'deactivateQuizz') {
                $quizzId = $_POST['quizzId'];
                deactivateQuizz($quizzId);
                echo "<script>window.location.href = window.location.pathname;</script>";
                exit;
            } elseif (isset($_POST['function']) && $_POST['function'] == 'activateQuizz') {
                $quizzId = $_POST['quizzId'];
                activateQuizz($quizzId);
                echo "<script>window.location.href = window.location.pathname;</script>";
                exit;
                
            }
        }
    } else {
        echo "Invalid token.";
        die();
    }
    
} else {
    header("Location: /login");
    exit();
}


require "views/header.php";
require "views/homeView.php";
require "views/footer.php";