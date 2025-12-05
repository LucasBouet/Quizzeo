<?php 
function getUserNoteForQuizz(int $userId, int $quizzId) : ?int {
    $pdo = getDatabaseConnection();
    $stmt = $pdo->prepare("SELECT Note FROM Participation_users WHERE Id_user = :userId AND Id_quizz = :quizzId;");
    $stmt->execute([
        "userId" => $userId,
        "quizzId" => $quizzId
    ]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result ? (int)$result['Note'] : null;
}

function getAverageNoteByQuizzId(int $quizzId) : float {
    $pdo = getDatabaseConnection();
    $stmt = $pdo->prepare("SELECT AVG(Note) FROM Participation_users WHERE Id_quizz = :quizzId;");
    $stmt->execute([
        "quizzId" => $quizzId
    ]);
    return (float)$stmt->fetchColumn();
}

function addPassedQuestionQcmEcole(int $questionId) : void {
    $pdo = getDatabaseConnection();
    $stmt = $pdo->prepare("UPDATE Questions_checkbox_ecole SET Passed = Passed + 1 WHERE ID = :question_id;");
    $stmt->execute([
        "question_id" => $questionId
    ]);
}

function updateQcmEcolePoints(int $id, int $points) : void {
    $pdo = getDatabaseConnection();
    $stmt = $pdo->prepare("UPDATE `Questions_checkbox_ecole` SET `Points` = :points WHERE `id` = :id");
    $stmt->execute([
        "id" => $id,
        "points" => $points,
    ]);
}

function addPassedQuestionLibreEcole(int $questionId) : void {
    $pdo = getDatabaseConnection();
    $stmt = $pdo->prepare("UPDATE Questions_libre_ecole SET Passed = Passed + 1 WHERE ID = :question_id;");
    $stmt->execute([
        "question_id" => $questionId
    ]);
}

function addParticipationWithNote(int $userId, int $quizzId, int $note) : void {
    $pdo = getDatabaseConnection();
    $stmt = $pdo->prepare("INSERT INTO Participation_users (Id_user, Id_quizz, Note) VALUES (:user_id, :quizz_id, :note);");
    $stmt->execute([
        "user_id" => $userId,
        "quizz_id" => $quizzId,
        "note" => $note
    ]);
}

function getReponsesCheckboxEcoleByQuestionId(int $questionId) {
    $pdo = getDatabaseConnection();
    $stmt = $pdo->prepare("SELECT * FROM Answers_checkbox_ecole WHERE Question_id = :question_id;");
    $stmt->execute([
        "question_id" => $questionId
    ]);
    return $stmt->fetchAll();
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
    $stmt = $pdo->prepare("SELECT Quizz_id, ID, Reponse FROM Questions_libre_ecole;");
    $stmt->execute();
    return $stmt->fetchAll();
}

function suppAnswersCheckboxEcoleByQuestionId(int $quizzId) : void {
    $pdo = getDatabaseConnection();
    $stmt = $pdo->prepare("DELETE FROM Answers_checkbox_ecole WHERE Question_id = :question_id;");
    $stmt->execute([
        "question_id" => $quizzId
    ]);
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
        "INSERT INTO `Questions_checkbox_ecole` (`Quizz_id`, `Position`, `Points`, `Question`) VALUES (:quizzid, :position, :points, :question)",
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
    $stmt = $pdo->prepare("SELECT * FROM `Questions_checkbox_ecole` WHERE `Id` = :id");
    $stmt->execute([
        "id" => $id,
    ]);
    return $stmt->fetch();
}

function getQcmEcole(): ?array {
    $pdo = getDatabaseConnection();
    $stmt = $pdo->prepare("SELECT * FROM `Questions_checkbox_ecole`");
    $stmt->execute();
    return $stmt->fetchAll();
}

function suppQcmEcole(int $id) : void {
    $pdo = getDatabaseConnection();
    $stmt = $pdo->prepare("DELETE FROM `Questions_checkbox_ecole` WHERE `id` = :id");
    $stmt->execute([
        "id" => $id,
    ]);
}

function updateQcmEcole(int $id, int $position, string $question, int $points): void {
    $pdo = getDatabaseConnection();
    $stmt = $pdo->prepare("UPDATE `Questions_checkbox_ecole` SET `Question` = :question, `Position` = :position, `Points` = :points WHERE `id` = :id");
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
        "isanswer" => (int)$isanswer,
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
?>