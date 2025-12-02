<?php

require "models/databaseModel.php";
require "models/jwt.php";
require "models/createModel.php";


// ----------------------------- logic

if (isset($_COOKIE["auth_token"])) {
    $jwtHelper = new JWT();
    $jwt = $jwtHelper->decode($_COOKIE["auth_token"]);
    $role = $jwt['body']['role'];
        if ($role == "Entreprise") {
            $quizzs = getAllQuizzs();
            $questions = [];
            foreach ($quizzs as $quizz) {
                $questions[$quizz['ID']] = [];
                $maxPosition = getMaxPositionEntreprise($quizz['ID']);
                for ($i = 1; $i <= $maxPosition; $i++) {
                    array_push($questions[$quizz['ID']], getQuestionEntrepriseByQuizzAndPosition($quizz['ID'], $i));
                }
            }
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                if (isset($_POST['function']) && $_POST['function'] == 'createQuizz') {
                    $name = $_POST['name'];
                    $id = createQuizz($name, $jwt);
                    echo "Quizz created successfully with id $id";
                } elseif (isset($_POST['function']) && $_POST['function'] == 'createQuestion') {
                    $title = $_POST['title'];
                    $id = $_POST['id'];
                    $answers = $_POST['answers'] ?? '';
                    $type = $_POST['type'];
                    $position = getMaxPositionEntreprise($id) + 1;
                    
                    if ($type == 'multiple') {
                        $qcmId = createQcmEntreprise($id, $position, $title);
                        foreach ($answers as $answer) {
                            createReponseQcmEntreprise($qcmId, $answer);
                        }
                    } elseif ($type == 'libre') {
                        createQuestionLibreEntreprise($id, $position, $title);
                    }
                }
            } elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
                // Handle GET request
            }
    } else {
        echo "Invalid token.";
        die();
    }
} else {
    echo "you must be logged in <a style='color: blue;' href='/register'>register there</a>";
    die();
}

// ----------------------------- requirements

require "views/header.php";
require "views/createView.php";
require "views/footer.php";
