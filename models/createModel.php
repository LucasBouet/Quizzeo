<?php
function createQuizz(string $name, array $jwt): int
{
    $pdo = getDatabaseConnection();
    $stmt = $pdo->prepare(
        "INSERT INTO `Quizzs` (`Name`, `Creator_id`, `Active`, `Finished`) VALUES (:name, :id, 0,0)",
    );
    $stmt->execute([
        "name" => $name,
        "id" => $jwt["body"]["user_id"],
    ]);
    return $pdo->lastInsertId();
}

function getAllQuizzs(): array
{
    $pdo = getDatabaseConnection();
    $stmt = $pdo->prepare("SELECT * FROM `Quizzs`");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getQuizzById(int $id): array
{
    $pdo = getDatabaseConnection();
    $stmt = $pdo->prepare("SELECT * FROM `Quizzs` WHERE `id` = :id");
    $stmt->execute([
        "id" => $id,
    ]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function suppQuizz(int $id): void
{
    $pdo = getDatabaseConnection();
    $stmt = $pdo->prepare("DELETE FROM `Quizzs` WHERE `id` = :id");
    $stmt->execute([
        "id" => $id,
    ]);
}

function updateQuizz(int $id, string $title): void {
    $pdo = getDatabaseConnection();
    $stmt = $pdo->prepare("UPDATE `Quizzs` SET `Title` = :title WHERE `id` = :id");
    $stmt->execute([
        "id" => $id,
        "title" => $title,
    ]);
}

// ---------------------------------- ecole

function createQuestionLibreEcole(
    int $quizzid,
    int $position,
    string $question,
    string $reponse,
    int $points,
): int {
    $pdo = getDatabaseConnection();
    $stmt = $pdo->prepare(
        "INSERT INTO `Questions_libre_ecole` (`Quizz_id`, `Position`, `Question`, `Reponse`, `Points`) VALUES (:Quizz_id, :position, :question, :reponse, :points)",
    );
    $stmt->execute([
        "Quizz_id" => $quizzid,
        "position" => $position,
        "question" => $question,
        "reponse" => $reponse,
        "points" => $points,
    ]);
    return $pdo->lastInsertId();
}

function getQuestionLibreEcoleById(int $quizzid) : ?array {
    $pdo = getDatabaseConnection();
    $stmt = $pdo->prepare("SELECT * FROM `Questions_libre_ecole` WHERE `Quizz_id` = :quizzid");
    $stmt->execute([
        "quizzid" => $quizzid,
    ]);
    return $stmt->fetch();
}

function getQuestionLibreEcole() : ?array {
    $pdo = getDatabaseConnection();
    $stmt = $pdo->prepare("SELECT * FROM `Questions_libre_ecole`");
    $stmt->execute();
    return $stmt->fetchAll();
}

function suppQuestionLibreEcole(int $id) : void {
    $pdo = getDatabaseConnection();
    $stmt = $pdo->prepare("DELETE FROM `Questions_libre_ecole` WHERE `id` = :id");
    $stmt->execute([
        "id" => $id,
    ]);
}

function updateQuestionLibreEcole(int $id, int $position, string $question, string $reponse, int $points): void {
    $pdo = getDatabaseConnection();
    $stmt = $pdo->prepare("UPDATE `Questions_libre_ecole` SET `Question` = :question, `Position` = :position, `Reponse` = :reponse, `Points` = :points WHERE `id` = :id");
    $stmt->execute([
        "id" => $id,
        "question" => $question,
        "position" => $position,
        "reponse" => $reponse,
        "points" => $points,
    ]);
}

function createQcmEcole(int $quizzid, int $position, int $points, string $question): int
{
    $pdo = getDatabaseConnection();
    $stmt = $pdo->prepare(
        "INSERT INTO `Questions_qcm_ecole` (`Quizz_id`, `Position`, `Points`, `Question`) VALUES (:quizzid, :position, :points, :question)",
    );
    $stmt->execute([
        "quizzid" => $quizzid,
        "position" => $position,
        "points" => $points,
        "question" => $question,
    ]);
    return $pdo->lastInsertId();
}

function getQcmEcoleById(int $id): ?array {
    $pdo = getDatabaseConnection();
    $stmt = $pdo->prepare("SELECT * FROM `Questions_qcm_ecole` WHERE `Id` = :id");
    $stmt->execute([
        "id" => $id,
    ]);
    return $stmt->fetch();
}

function getQcmEcole(): ?array {
    $pdo = getDatabaseConnection();
    $stmt = $pdo->prepare("SELECT * FROM `Questions_qcm_ecole`");
    $stmt->execute();
    return $stmt->fetchAll();
}

function suppQcmEcole(int $id) : void {
    $pdo = getDatabaseConnection();
    $stmt = $pdo->prepare("DELETE FROM `Questions_qcm_ecole` WHERE `id` = :id");
    $stmt->execute([
        "id" => $id,
    ]);
}

function updateQcmEcole(int $id, int $position, string $question, int $points): void {
    $pdo = getDatabaseConnection();
    $stmt = $pdo->prepare("UPDATE `Questions_qcm_ecole` SET `Question` = :question, `Position` = :position, `Points` = :points WHERE `id` = :id");
    $stmt->execute([
        "id" => $id,
        "question" => $question,
        "position" => $position,
        "points" => $points,
    ]);
}

function createReponseQcmEcole(
    int $questionid,
    string $text,
    bool $isanswer,
): int {
    $pdo = getDatabaseConnection();
    $stmt = $pdo->prepare(
        "INSERT INTO `Answers_checkbox_ecole` (`Question_id`, `Text`, `Is_answer`) VALUES (:questionid, :text, :isanswer)",
    );
    $stmt->execute([
        "questionid" => $questionid,
        "text" => $text,
        "isanswer" => $isanswer,
    ]);
    return $pdo->lastInsertId();
}

function getReponseEcoleById(int $id) : ?array {
    $pdo = getDatabaseConnection();
    $stmt = $pdo->prepare("SELECT * FROM `Answers_checkbox_ecole` WHERE `Id` = :id");
    $stmt->execute([
        "id" => $id,
    ]);
    return $stmt->fetch();
}

function getReponseEcole() : ?array {
    $pdo = getDatabaseConnection();
    $stmt = $pdo->prepare("SELECT * FROM `Answers_checkbox_ecole`");
    $stmt->execute();
    return $stmt->fetchAll();
}

function suppReponseEcole(int $id) : void {
    $pdo = getDatabaseConnection();
    $stmt = $pdo->prepare("DELETE FROM `Answers_checkbox_ecole` WHERE `Id` = :id");
    $stmt->execute([
        "id" => $id,
    ]);
}

function updateReponseEcole(int $id, string $reponse, bool $isanswer): void {
    $pdo = getDatabaseConnection();
    $stmt = $pdo->prepare("UPDATE `Answers_checkbox_ecole` SET `Reponse` = :reponse, `IsAnswer` = :isanswer WHERE `Id` = :id");
    $stmt->execute([
        "id" => $id,
        "reponse" => $reponse,
        "isanswer" => $isanswer,
    ]);
}

// ---------------------------------- entreprise

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

function getMaxPositionEcole(int $quizzId) : int {
    $pdo = getDatabaseConnection();

    $sql = "SELECT COALESCE(MAX(Position), 0) AS maxpos FROM Questions_libre_ecole WHERE Quizz_id = :qid UNION SELECT COALESCE(MAX(Position), 0) FROM Questions_checkbox_ecole WHERE Quizz_id = :qid2 ORDER BY maxpos DESC LIMIT 1;";

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

function getQuestionEcoleByQuizzAndPosition(int $id, int $position) {
    $pdo = getDatabaseConnection();
    $stmt = $pdo->prepare("SELECT * FROM (SELECT ID, Quizz_id, Position, Question, Points, 'libre' AS Type FROM Questions_libre_ecole WHERE Quizz_id = :quizz_id UNION ALL SELECT ID, Quizz_id, Position, Question, Points, 'checkbox' AS Type FROM Questions_checkbox_ecole WHERE Quizz_id = :quizz_id2) AS all_questions WHERE Position = :position ORDER BY ID LIMIT 1;");
    $stmt->execute([
        "quizz_id" => $id,
        "quizz_id2" => $id,
        "position" => $position
    ]);
    return $stmt->fetch();
}

function getReponseLibreEcole() {
    $pdo = getDatabaseConnection();
    $stmt = $pdo->prepare("SELECT Quizz_id, Reponse FROM Questions_libre_ecole;");
    $stmt->execute();
    return $stmt->fetchAll();
}

?>