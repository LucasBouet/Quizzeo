<?php

require "models/databaseModel.php";

function createQuizz(string $name, array $jwt) : int {
    $pdo = getDatabaseConnection();
    $stmt = $pdo->prepare("INSERT INTO `Quizzs` (`Name`, `Creator_id`, `Active`, `Finished`) VALUES (:name, :id, 0,0)");
    $stmt->execute([
        'title' => $name,
        'id' => $jwt['body']['user_id']
    ]);
    return $pdo->lastInsertId();
}

if (isset($_COOKIE["auth_token"])) {
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