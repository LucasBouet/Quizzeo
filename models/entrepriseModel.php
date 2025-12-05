<?php
function createQuestionLibreEntreprise(int $quizzid, int $position, string $question)
{
    $pdo = getDatabaseConnection();
    $stmt = $pdo->prepare(
        "INSERT INTO `Questions_libre_entreprise` (`Quizz_id`, `Position`, `Question`) VALUES (:quizzid, :position, :question)",
    );
    $stmt->execute([
        "quizzid" => $quizzid,
        "position" => $position,
        "question" => $question,
    ]);
    return $pdo->lastInsertId();
}

function getQuestionLibreEntrepriseById(int $id) : ?array {
    $pdo = getDatabaseConnection();
    $stmt = $pdo->prepare("SELECT * FROM `Questions_libre_entreprise` WHERE `Id` = :id");
    $stmt->execute([
        "id" => $id,
    ]);
    return $stmt->fetch();
}

function getQuestionLibreEntreprise() : ?array {
    $pdo = getDatabaseConnection();
    $stmt = $pdo->prepare("SELECT * FROM `Questions_libre_entreprise`");
    $stmt->execute();
    return $stmt->fetchAll();
}

function suppQuestionLibreEntreprise(int $id) : void {
    $pdo = getDatabaseConnection();
    $stmt = $pdo->prepare("DELETE FROM `Questions_libre_entreprise` WHERE `Id` = :id");
    $stmt->execute([
        "id" => $id,
    ]);
}

function updateQuestionLibreEntreprise(int $id, int $position, string $question): void {
    $pdo = getDatabaseConnection();
    $stmt = $pdo->prepare("UPDATE `Questions_libre_entreprise` SET `Question` = :question, `Position` = :position WHERE `Id` = :id");
    $stmt->execute([
        "id" => $id,
        "question" => $question,
        "position" => $position,
    ]);
}

function createQcmEntreprise(int $quizzid, int $position, string $question): int
{
    $pdo = getDatabaseConnection();
    $stmt = $pdo->prepare(
        "INSERT INTO `Questions_checkbox_entreprise` (`Quizz_id`, `Position`, `Question`) VALUES (:quizzid, :position, :question)",
    );
    $stmt->execute([
        "quizzid" => $quizzid,
        "position" => $position,
        "question" => $question,
    ]);
    return $pdo->lastInsertId();
}

function getQcmEntrepriseById(int $id) : ?array {
    $pdo = getDatabaseConnection();
    $stmt = $pdo->prepare("SELECT * FROM `Questions_checkbox_entreprise` WHERE `Id` = :id");
    $stmt->execute([
        "id" => $id,
    ]);
    return $stmt->fetch();
}

function getQcmEntreprise() : ?array {
    $pdo = getDatabaseConnection();
    $stmt = $pdo->prepare("SELECT * FROM `Questions_checkbox_entreprise`");
    $stmt->execute();
    return $stmt->fetchAll();
}

function suppQcmEntreprise(int $id) : void {
    $pdo = getDatabaseConnection();
    $stmt = $pdo->prepare("DELETE FROM `Questions_checkbox_entreprise` WHERE `Id` = :id");
    $stmt->execute([
        "id" => $id,
    ]);
}

function updateQcmEntreprise(int $id, int $position, string $question): void {
    $pdo = getDatabaseConnection();
    $stmt = $pdo->prepare("UPDATE `Questions_checkbox_entreprise` SET `Question` = :question, `Position` = :position WHERE `Id` = :id");
    $stmt->execute([
        "id" => $id,
        "question" => $question,
        "position" => $position,
    ]);
}

function createReponseQcmEntreprise(int $questionid, string $text): int
{
    $pdo = getDatabaseConnection();
    $stmt = $pdo->prepare(
        "INSERT INTO `Answers_checkbox_entreprise` (`Question_id`, `Text`) VALUES (:questionid, :text)",
    );
    $stmt->execute([
        "questionid" => $questionid,
        "text" => $text,
    ]);
    return $pdo->lastInsertId();
}

function getReponseQcmEntrepriseById(int $id) : ?array {
    $pdo = getDatabaseConnection();
    $stmt = $pdo->prepare("SELECT * FROM `Answers_checkbox_entreprise` WHERE `Id` = :id");
    $stmt->execute([
        "id" => $id,
    ]);
    return $stmt->fetch();
}

function getReponseQcmEntreprise() : ?array {
    $pdo = getDatabaseConnection();
    $stmt = $pdo->prepare("SELECT * FROM `Answers_checkbox_entreprise`");
    $stmt->execute();
    return $stmt->fetchAll();
}

function suppReponseQcmEntreprise(int $id) : void {
    $pdo = getDatabaseConnection();
    $stmt = $pdo->prepare("DELETE FROM `Answers_checkbox_entreprise` WHERE `Id` = :id");
    $stmt->execute([
        "id" => $id,
    ]);
}

function updateReponseQcmEntreprise(int $id, string $text): void {
    $pdo = getDatabaseConnection();
    $stmt = $pdo->prepare("UPDATE `Answers_checkbox_entreprise` SET `Text` = :text WHERE `Id` = :id");
    $stmt->execute([
        "id" => $id,
        "text" => $text,
    ]);
}

function getMaxPositionEntreprise(int $quizzId) : int {
    $pdo = getDatabaseConnection();

    $sql = "SELECT COALESCE(MAX(Position), 0) AS maxpos FROM Questions_libre_entreprise WHERE Quizz_id = :qid UNION SELECT COALESCE(MAX(Position), 0) FROM Questions_checkbox_entreprise WHERE Quizz_id = :qid2 ORDER BY maxpos DESC LIMIT 1;";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        'qid' => $quizzId,
        'qid2' => $quizzId
    ]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    return (int) $result['maxpos'];
}

function getQuestionEntrepriseByQuizzAndPosition(int $id, int $position) {
    $pdo = getDatabaseConnection();
    $stmt = $pdo->prepare("SELECT * FROM (SELECT ID, Quizz_id, Position, Question, 'libre' AS Type FROM Questions_libre_entreprise WHERE Quizz_id = :quizz_id UNION ALL SELECT ID, Quizz_id, Position, Question, 'checkbox' AS Type FROM Questions_checkbox_entreprise WHERE Quizz_id = :quizz_id2) AS all_questions WHERE Position = :position ORDER BY ID LIMIT 1;");
    $stmt->execute([
        "quizz_id" => $id,
        "quizz_id2" => $id,
        "position" => $position
    ]);
    return $stmt->fetch();
}

function getReponsesCheckboxEntrepriseByQuestionId(int $questionId) {
    $pdo = getDatabaseConnection();
    $stmt = $pdo->prepare("SELECT * FROM Answers_checkbox_entreprise WHERE Question_id = :question_id;");
    $stmt->execute([
        "question_id" => $questionId
    ]);
    return $stmt->fetchAll();
}

function addReponseLibreEntreprise(int $questionId, string $reponse) : void {
    $pdo = getDatabaseConnection();
    $stmt = $pdo->prepare("INSERT INTO Reponses_libre_entreprise (Question_id, Text) VALUES (:question_id, :reponse);");
    $stmt->execute([
        "question_id" => $questionId,
        "reponse" => $reponse
    ]);
}

function addOneAnsweredCheckboxEntreprise(int $id) : void {
    $pdo = getDatabaseConnection();
    $stmt = $pdo->prepare("UPDATE Answers_checkbox_entreprise SET Answered = Answered + 1 WHERE ID = :id;");
    $stmt->execute([
        "id" => $id
    ]);
}

function addParticipation(int $userId, int $quizzId) : void {
    $pdo = getDatabaseConnection();
    $stmt = $pdo->prepare("INSERT INTO Participation_users (Id_user, Id_quizz) VALUES (:user_id, :quizz_id);");
    $stmt->execute([
        "user_id" => $userId,
        "quizz_id" => $quizzId
    ]);
}

function getReponseLibreEntrepriseById(int $id) {
    $pdo = getDatabaseConnection();
    $stmt = $pdo->prepare("SELECT * FROM Reponses_libre_entreprise WHERE Question_id = :id");
    $stmt->execute([
        "id" => $id,
    ]);
    return $stmt->fetchAll();
}

function getReponseQcmEntrepriseByQuestionId(int $questionId) {
    $pdo = getDatabaseConnection();
    $stmt = $pdo->prepare("SELECT * FROM Answers_checkbox_entreprise WHERE Question_id = :question_id;");
    $stmt->execute([
        "question_id" => $questionId
    ]);
    return $stmt->fetchAll();
}
?>