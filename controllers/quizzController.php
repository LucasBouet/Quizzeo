<?php

require "models/databaseModel.php";
require "models/createModel.php";
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
            echo "<pre>";
            var_dump($quizz);
            echo "</pre>";
            echo "<pre>";
            var_dump($quizzData);
            echo "</pre>";
            echo "<pre>";
            var_dump($questions);
            echo "</pre>";
            echo "<pre>";
            var_dump($reponses);
            echo "</pre>";
            // die();
        } elseif ($creatorRole == "Ecole") {
            // ecole
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
            echo "<pre>";
            var_dump($quizz);
            echo "</pre>";
            echo "<pre>";
            var_dump($quizzData);
            echo "</pre>";
            echo "<pre>";
            var_dump($questions);
            echo "</pre>";
            echo "<pre>";
            var_dump($reponses);
            echo "</pre>";
            echo "<pre>";
            var_dump($reponsesLibres);
            echo "</pre>";
            // die();
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
        
        echo "<pre>";
        var_dump($formAnswers);
        echo "</pre>";
        echo "<pre>";
        var_dump($userId);
        echo "</pre>";
        // die();
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
        
        echo "<pre>";
        var_dump($formAnswers);
        echo "</pre>";
        echo "<pre>";
        var_dump($userId);
        echo "</pre>";
        echo "<pre>";
        var_dump($reponsesLibres);
        echo "</pre>";
        echo "Question id :<pre>";
        var_dump($questionIds);
        echo "</pre>";
        // die();
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
                
                echo '<br/>'.$localAnswer.'<br/>';
                if (comparer_flou_similarite($localAnswer, $value, 90.0)) {
                    $localNote = 0;
                    foreach ($questions as $q) {
                        if ($q['Type'] == 'libre') {
                            if ($q['ID'] == $questionId) {
                                $localNote = $q['Points'];
                                break;
                            }
                        }
                    }
                    $note += $localNote;
                    addPassedQuestionLibreEcole($questionId);
                }
            } else {
                $questionId = $questionIds[$key];
                $localReponses = getReponsesCheckboxEcoleByQuestionId($questionId);
                echo "<br/>Reponses:<br/><pre>";
                var_dump($localReponses);
                echo "</pre>";
                // die();
                // IDs bonnes réponses
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
                    // bonne question
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
                // foreach($value as $place => $checked) {
                //     foreach($localReponses as $localReponse) {
                //         if ($localReponse['ID'] == $checked) {
                //             if ($localReponse['Is_answer'] == 1) {
                //                 $localNote = 0;
                //                 foreach ($questions as $q) {
                //                     if ($q['Type'] == 'checkbox') {
                //                         if ($q['ID'] == $questionId) {
                //                             $localNote = $q['Points'];
                //                             break;
                //                         }
                //                     }
                //                 }
                //                 $note += $localNote;
                //                 // addPassedQuestionCheckboxEcole($checked);
                //             }
                //         }
                //     }
                // }
            }
        }
        // addParticipation($userId, $quizzId);
        echo "<br/>";
        var_dump($note);
        echo "<br/>";
        echo "Thank you for your submission!";
        die();
    }
    
}

require "views/header.php";
require "views/quizzView.php";
require "views/footer.php";