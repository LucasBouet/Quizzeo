<?php

require "models/databaseModel.php";
require "models/entrepriseModel.php";
require "models/ecoleModel.php";
require "models/utilityModel.php";
require "models/jwt.php";

if ($_SERVER['REQUEST_METHOD'] === "GET") {

    if (!isset($_COOKIE["auth_token"])) {
        header("Location: /login");
        exit();
    }

    $jwtHelper = new JWT();
    $jwt = $jwtHelper->decode($_COOKIE["auth_token"]);

    if (!$jwt) {
        header("Location: /login");
        exit();
    }

    $userRole = $jwt['body']['role'] ?? null;

    if ($userRole !== 'Default' || $userRole === null) {
        header("Location: /login");
        exit();
    }

    $quizz = $_GET['quizz'] ?? null;

    if (!$quizz) {
        header('Location: /');
        exit();
    }

    $quizzData = getQuizzById($quizz);

    if ($quizzData) {
        $userId = $jwt['body']['user_id'] ?? null;
        echo "Quizz found and ready to display! <br/>";
        $creatorRole = getRoleFromQuizzId($quizz);
        echo "Quizz created by a(n) $creatorRole";
        
        if (checkIfUserHasParticipated($userId, $quizz)) {
            echo "<br/>You have already participated in this quizz.<br/>";
            die();
        }
        
        if (!isQuizzActive($quizz)) {
            echo "<br/>This quizz is not active.<br/>";
            die();
        }
        
        if (!isQuizzFinished($quizz)) {
            echo "<br/>This quizz is not yet available.<br/>";
            die();
        }
        
        if ($creatorRole == "Entreprise") {
            // entreprise
            $questions = [];
            $reponses = [];
            $maxNumberOfQuestions = getMaxPositionEntreprise($quizz);
            for ($i = 1; $i <= $maxNumberOfQuestions; $i++) {
                $questions[$i] = getQuestionEntrepriseByQuizzAndPosition($quizz, $i);
                if (is_array($questions[$i])) {
                    if ($questions[$i]['Type'] == 'checkbox') {
                        $reponses[$questions[$i]['Position']] = getReponsesCheckboxEntrepriseByQuestionId($questions[$i]['ID']);
                    }
                }
                
            }

        } elseif ($creatorRole == "Ecole") {
            $questions = [];
            $reponses = [];
            $maxNumberOfQuestions = getMaxPositionEcole($quizz);
            for ($i = 1; $i <= $maxNumberOfQuestions; $i++) {
                $questions[$i] = getQuestionEcoleByQuizzAndPosition($quizz, $i);
                if (is_array($questions[$i])) {
                    if ($questions[$i]['Type'] == 'checkbox') {
                        $reponses[$questions[$i]['Position']] = getReponsesCheckboxEcoleByQuestionId($questions[$i]['ID']);
                    }
                }
                
            }
            $reponsesLibres = getReponseLibreEcole($quizz);
        }
    } else {
        header('Location: /');
        exit();
    }
} elseif ($_SERVER['REQUEST_METHOD'] == "POST") {
    $quizzId = $_POST['quizzId'];
    $creatorRole = getRoleFromQuizzId($quizzId);
    if ($creatorRole == 'Entreprise') {
        $userId = $_POST['userId'];
        $formAnswers = $_POST['answer'];
        $questions = [];
        $reponses = [];
        $maxNumberOfQuestions = getMaxPositionEntreprise($quizzId);
        for ($i = 1; $i <= $maxNumberOfQuestions; $i++) {
            $questions[$i] = getQuestionEntrepriseByQuizzAndPosition($quizzId, $i);
            if (is_array($questions[$i])) {
                if ($questions[$i]['Type'] == 'checkbox') {
                    $reponses[$questions[$i]['Position']] = getReponsesCheckboxEntrepriseByQuestionId($questions[$i]['ID']);
                }
            }
        }
        
        if (checkIfUserHasParticipated($userId, $quizzId)) {
            echo "You have already participated in this quizz.";
            die();
        }

        foreach($formAnswers as $key => $value) {
            if (!is_array($value)) {
                addReponseLibreEntreprise($questions[$key]['ID'], $value);
            } else {
                foreach($value as $checkboxChoosen) {
                    $answerId = (int)$checkboxChoosen;
                    addOneAnsweredCheckboxEntreprise($answerId);
                }
            }
        }
        addParticipation($userId, $quizzId);
        echo "Thank you for your submission!";
        die();
    } elseif ($creatorRole == 'Ecole') {
        $note = 0;
        $userId = $_POST['userId'];
        $questionIds = $_POST['questionId'];
        $formAnswers = $_POST['answer'];
        $questions = [];
        $reponsesLibres = getReponseLibreEcole($quizzId);
        $reponses = [];
        $maxNumberOfQuestions = getMaxPositionEcole($quizzId);
        for ($i = 1; $i <= $maxNumberOfQuestions; $i++) {
            $questions[$i] = getQuestionEcoleByQuizzAndPosition($quizzId, $i);
            if (is_array($questions[$i])) {
                if ($questions[$i]['Type'] == 'checkbox') {
                    $reponses[$questions[$i]['Position']] = getReponsesCheckboxEcoleByQuestionId($questions[$i]['ID']);
                }
            }
        }

        if (checkIfUserHasParticipated($userId, $quizzId)) {
            echo "You have already participated in this quizz.";
            die();
        }
        
        foreach($formAnswers as $key => $value) {
            if (!is_array($value)) {
                // calculate 
                $questionId = $questionIds[$key];
                $localAnswer = '';
                foreach ($reponsesLibres as $rep) {
                    if ($rep['ID'] == $questionId) {
                        $localAnswer = $rep['Reponse'];
                        break;
                    }
                }
                
                if (comparer_flou_similarite($localAnswer, $value, 90.0)) {
                    $localNote = 0;
                    foreach ($questions as $q) {
                        if (is_array($q)) {
                            if ($q['Type'] == 'libre') {
                                if ($q['ID'] == $questionId) {
                                    $localNote = $q['Points'];
                                    break;
                                }
                            }
                        }
                    }
                    $note += $localNote;
                    addPassedQuestionLibreEcole($questionId);
                }
            } else {
                $questionId = $questionIds[$key];
                $localReponses = getReponsesCheckboxEcoleByQuestionId($questionId);

                $goodIds = array_map('intval',
                    array_column(
                        array_filter($localReponses, fn($r) => $r['Is_answer'] == 1),
                        'ID'
                    )
                );
                
                // IDs cochées par l’utilisateur
                $userChecked = array_map('intval', $value);
                
                // Comparaison exacte
                sort($goodIds);
                sort($userChecked);
                
                if ($goodIds === $userChecked) {
                    $localNote = 0;
                    foreach ($questions as $q) {
                        if (is_array($q)) {
                            if ($q['Type'] == 'checkbox') {
                                if ($q['ID'] == $questionId) {
                                    $localNote = $q['Points'];
                                    break;
                                }
                            }
                        }
                    }
                    $note += $localNote;
                    addPassedQuestionQcmEcole($questionId);
                }
            }
        }
        addParticipationWithNote($userId, $quizzId, $note);
        $totalMaxNote = getTotalpointsByQuizzId($quizzId);
        echo "<br/>";
        echo "<h1>Your total score is $note / $totalMaxNote<h1>";
        echo "<br/>";
        echo "Thank you for your submission!";
        die();
    }
    
}

require "views/header.php";
require "views/quizzView.php";
require "views/footer.php";