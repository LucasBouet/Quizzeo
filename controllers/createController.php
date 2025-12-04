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
            $reponses = getReponseQcmEntreprise();
            foreach ($quizzs as $quizz) {
                $questions[$quizz['ID']] = [];
                $maxPosition = getMaxPositionEntreprise($quizz['ID']);
                var_dump($maxPosition);
                echo "<br/>";
                for ($i = 1; $i <= $maxPosition; $i++) {
                    array_push($questions[$quizz['ID']], getQuestionEntrepriseByQuizzAndPosition($quizz['ID'], $i));
                }
                
            }
            echo "<pre>";
            var_dump($questions);
            echo "</pre><br/>";
            echo "<pre>";
            var_dump($reponses);
            echo "</pre><br/>";
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                if (isset($_POST['function']) && $_POST['function'] == 'createQuizz') {
                    $name = $_POST['name'];
                    $id = createQuizz($name, $jwt);
                    echo "Quizz created successfully with id $id";
                    echo "<script>window.location.href = window.location.pathname;</script>";
                    exit;
                } elseif (isset($_POST['function']) && $_POST['function'] == 'createQuestionEntreprise') {
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
                        echo "<script>window.location.href = window.location.pathname;</script>";
                        exit;
                    } elseif ($type == 'libre') {
                        createQuestionLibreEntreprise($id, $position, $title);
                        echo "<script>window.location.href = window.location.pathname;</script>";
                        exit;
                    }
                } elseif (isset($_POST['function']) && $_POST['function'] == 'updateQuestionLibreEntreprise') {
                    $questionId = $_POST['id'];
                    $question = $_POST['question'];
                    $position = $_POST['position'];
                    updateQuestionLibreEntreprise($questionId, $position, $question);
                    echo "<script>window.location.href = window.location.pathname;</script>";
                    exit;
                    
                } elseif (isset($_POST['function']) && $_POST['function'] == 'suppQuestionLibreEntreprise') {
                    $questionId = $_POST['id'];
                    suppQuestionLibreEntreprise($questionId);
                    echo "<script>window.location.href = window.location.pathname;</script>";
                    exit;
                    
                } elseif (isset($_POST['function']) && $_POST['function'] == 'suppQuizz') {
                    $quizzId = $_POST['id'];
                    suppQuizz($quizzId);
                    echo "<script>window.location.href = window.location.pathname;</script>";
                    exit;
                    
                } elseif (isset($_POST['function']) && $_POST['function'] == 'suppQuestionMultiple') {
                    $questionId = $_POST['id'];
                    suppQcmEntreprise($questionId);
                    echo "<script>window.location.href = window.location.pathname;</script>";
                    exit;
                    
                } elseif (isset($_POST['function']) && $_POST['function'] == 'updateQuestionMultiple') {
                    $answers = $_POST['answers'];
                    $answerIds = $_POST['answer_ids'] ?? [];
                    $questionId = $_POST['id'];
                    $question = $_POST['question'];
                    $position = $_POST['position'];
                    $subarray = $questions[$questionId];
                    echo "<pre>";
                    var_dump($reponses);
                    var_dump($answers);
                    echo "</pre>";
                    $oldAnswers = [];
                    foreach ($reponses as $rep) {
                        $oldAnswers[$rep['ID']] = $rep['Text'];
                    }
                    
                    if (isset($answerIds)) {
                        foreach ($answerIds as $idx => $id) {
                            if (isset($oldAnswers[$id])) {
                                if ($oldAnswers[$id] != $answers[$idx]) {
                                    updateReponseQcmEntreprise($id, $answers[$idx]);
                                }
                                unset($oldAnswers[$id]);
                            }
                        }
                    }
                    
                    foreach ($oldAnswers as $id => $txt) {
                        suppReponseQcmEntreprise($id);
                    }
                    
                    if (count($answers) > count($answerIds)) {
                        for ($i = count($answerIds); $i < count($answers); $i++) {
                            createReponseQcmEntreprise($questionId, $answers[$i]);
                        }
                    }
                    echo "<script>window.location.href = window.location.pathname;</script>";
                    exit;
                    
                }
            } elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
                // Handle GET request
            }
            
    } elseif ($role == 'Ecole') {
        $quizzs = getAllQuizzs();
        $questions = [];
        $reponses = getReponseEcole();
        $reponsesLibres = getReponseLibreEcole();
        foreach ($quizzs as $quizz) {
            $questions[$quizz['ID']] = [];
            $maxPosition = getMaxPositionEcole($quizz['ID']);
            var_dump($maxPosition);
            echo "<br/>";
            for ($i = 1; $i <= $maxPosition; $i++) {
                array_push($questions[$quizz['ID']], getQuestionEcoleByQuizzAndPosition($quizz['ID'], $i));
            }
            
        }
        echo "<pre>";
        echo "Questions:";
        var_dump($questions);
        echo "</pre><br/>";
        echo "<pre>";
        echo "Réponses:";
        var_dump($reponses);
        echo "</pre><br/>";
        echo "<pre>";
        echo "Réponses libres:";
        var_dump($reponsesLibres);
        echo "</pre><br/>";
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['function']) && $_POST['function'] == 'createQuizz') {
                $name = $_POST['name'];
                $id = createQuizz($name, $jwt);
                echo "<script>window.location.href = window.location.pathname;</script>";
                exit;
            } elseif (isset($_POST['function']) && $_POST['function'] == 'createQuestionEcole') {
                $title = $_POST['title'];
                $points = $_POST['points'];
                $id = $_POST['id'];
                $answers = $_POST['answers'] ?? '';
                $isAnswer = $_POST['isAnswer'] ?? '';
                $answerLibre = $_POST['answerLibre'] ?? '';
                $type = $_POST['type'];
                $position = getMaxPositionEcole($id) + 1;
                
                if ($type == 'multiple') {
                    echo "WORKING BRR BRR";
                    echo "<pre>";
                    var_dump($answers);
                    echo "</pre><br/>";
                    echo "<pre>";
                    var_dump($isAnswer);
                    echo "</pre><br/>";
                    
                    $qcmId = createQcmEcole($id, $position, $points, $title);
                    foreach ($answers as $key => $answer) {
                        $isCorrect = isset($isAnswer[$key]) && $isAnswer[$key] == "1" ? 1 : 0;
                        echo $isCorrect;
                        createReponseQcmEcole($qcmId, $answer, $isCorrect);
                    }
                    echo "<script>window.location.href = window.location.pathname;</script>";
                    exit;
                } elseif ($type == 'libre') {
                    createQuestionLibreEcole($id, $position, $title, $answerLibre, $points);

                    echo "<script>window.location.href = window.location.pathname;</script>";
                    exit;
                }
            } elseif (isset($_POST['function']) && $_POST['function'] == "suppQuizz") {
                if (isset($_POST['id']) && $_POST['id']) {
                    suppQuizz($_POST['id']);
                    echo "<script>window.location.href = window.location.pathname;</script>";
                    exit;
                }
            } elseif (isset($_POST['function']) && $_POST['function'] == "updateQuestionLibreEcole") {
                $id = $_POST['id'];
                $position = $_POST['position'];
                $title = $_POST['question'];
                $answerLibre = $_POST['answer'];
                $points = $_POST['points'];

                updateQuestionLibreEcole($id, $position, $title, $answerLibre, $points);
    
                echo "<script>window.location.href = window.location.pathname;</script>";
                exit;
            } elseif (isset($_POST['function']) && $_POST['function'] == "suppQuestionLibreEcole") {
                $id = $_POST['id'];
                suppQuestionLibreEcole($id);
                echo "<script>window.location.href = window.location.pathname;</script>";
                exit;
            } elseif (isset($_POST['function']) && $_POST['function'] == "suppQuestionMultiple") {
                $id = $_POST['id'];
                suppQcmEcole($id);
                echo "<script>window.location.href = window.location.pathname;</script>";
                exit;
            } elseif (isset($_POST['function']) && $_POST['function'] == "updateQuestionMultipleEcole") {
                $id = $_POST['id'];
                $position = $_POST['position'];
                $question = $_POST['question'];
                $points = $_POST['points'];
                $answers = $_POST['answers'];
                $isAnswer = $_POST['isAnswer'];
                echo "<pre>";
                var_dump($isAnswer);
                var_dump($answers);
                echo "</pre>";
                //die();
                $oldNote = getQcmEcoleById($id)['Poinst'];
                if ($oldNote != $points) {
                    updateQcmEcolePoints($id, $points);
                }
                suppAnswersCheckboxEcoleByQuestionId($id);
                foreach($answers as $key => $value) {
                    var_dump($value);
                    //die();
                    createReponseQcmEcole($id, $value, $isAnswer[$key]);
                }
                echo "<script>window.location.href = window.location.pathname;</script>";
                exit;
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
