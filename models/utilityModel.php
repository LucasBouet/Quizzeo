<?php 
function getAnsweredQuizzByUserId(int $userId) : array {
    $pdo = getDatabaseConnection();
    $stmt = $pdo->prepare("SELECT * FROM Quizzs JOIN Participation_users ON Quizzs.ID = Participation_users.Id_quizz WHERE Participation_users.Id_user = :userId;");
    $stmt->execute([
        "userId" => $userId
    ]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getNumberOfQuizzDoneByUserId(int $userId) : int {
    $pdo = getDatabaseConnection();
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM Participation_users WHERE Id_user = :userId;");
    $stmt->execute([
        "userId" => $userId
    ]);
    return (int)$stmt->fetchColumn();
}

function getNumberParticipationByQuizzId(int $quizzId) : int {
    $pdo = getDatabaseConnection();
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM Participation_users WHERE Id_quizz = :quizzId;");
    $stmt->execute([
        "quizzId" => $quizzId
    ]);
    return (int)$stmt->fetchColumn();
}

function getQuizzByCreatorId(int $creatorId) : array {
    $pdo = getDatabaseConnection();
    $stmt = $pdo->prepare("SELECT * FROM Quizzs WHERE Creator_id = :creatorId;");
    $stmt->execute([
        "creatorId" => $creatorId
    ]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function deactivateUser(int $userId) : void {
    $pdo = getDatabaseConnection();
    $stmt = $pdo->prepare("UPDATE Users SET Active = 0 WHERE ID = :userId;");
    $stmt->execute([
        "userId" => $userId
    ]);
}

function activateUser(int $userId) : void {
    $pdo = getDatabaseConnection();
    $stmt = $pdo->prepare("UPDATE Users SET Active = 1 WHERE ID = :userId;");
    $stmt->execute([
        "userId" => $userId
    ]);
}

function deactivateQuizz(int $quizzId) : void {
    $pdo = getDatabaseConnection();
    $stmt = $pdo->prepare("UPDATE Quizzs SET Active = 0 WHERE ID = :quizzId;");
    $stmt->execute([
        "quizzId" => $quizzId
    ]);
}

function activateQuizz(int $quizzId) : void {
    $pdo = getDatabaseConnection();
    $stmt = $pdo->prepare("UPDATE Quizzs SET Active = 1 WHERE ID = :quizzId;");
    $stmt->execute([
        "quizzId" => $quizzId
    ]);
}

function getAllUsers() : array {
    $pdo = getDatabaseConnection();
    $stmt = $pdo->prepare("SELECT * FROM Users;");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function finishQuizz(int $quizzId) : void {
    $pdo = getDatabaseConnection();
    $stmt = $pdo->prepare("UPDATE Quizzs SET Finished = 1 WHERE ID = :quizzId;");
    $stmt->execute([
        "quizzId" => $quizzId
    ]);
}

function unfinishQuizz(int $quizzId) : void {
    $pdo = getDatabaseConnection();
    $stmt = $pdo->prepare("UPDATE Quizzs SET Finished = 0 WHERE ID = :quizzId;");
    $stmt->execute([
        "quizzId" => $quizzId
    ]);
}

function isQuizzActive(int $quizzId) : bool {
    $pdo = getDatabaseConnection();
    $stmt = $pdo->prepare("SELECT Active FROM Quizzs WHERE ID = :quizzId;");
    $stmt->execute([
        "quizzId" => $quizzId
    ]);
    return (bool)$stmt->fetchColumn();
}

function isQuizzFinished(int $quizzId) : bool {
    $pdo = getDatabaseConnection();
    $stmt = $pdo->prepare("SELECT Finished FROM Quizzs WHERE ID = :quizzId;");
    $stmt->execute([
        "quizzId" => $quizzId
    ]);
    return (bool)$stmt->fetchColumn();
}

function getUserFromId(int $id) : array {
    $pdo = getDatabaseConnection();
    $stmt = $pdo->prepare("SELECT * FROM Users WHERE ID = :id;");
    $stmt->execute([
        "id" => $id
    ]);
    return $stmt->fetch();
}

function getTotalpointsByQuizzId(int $quizzId) : int {
    $pdo = getDatabaseConnection();
    $stmt = $pdo->prepare("SELECT SUM(Points) AS total_points FROM (SELECT Points FROM Questions_libre_ecole WHERE Quizz_id = :quizzId UNION ALL SELECT Points FROM Questions_checkbox_ecole WHERE Quizz_id = :quizzid2) AS all_points;");
    $stmt->execute([
        "quizzId" => $quizzId,
        "quizzid2" => $quizzId
    ]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return (int)$result['total_points'];
}

function checkIfUserHasParticipated(int $userId, int $quizzId) : bool {
    $pdo = getDatabaseConnection();
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM Participation_users WHERE Id_user = :user_id AND Id_quizz = :quizz_id;");
    $stmt->execute([
        "user_id" => $userId,
        "quizz_id" => $quizzId
    ]);
    return $stmt->fetchColumn() > 0;
}

function comparer_flou_similarite(string $reponse, string $input_user, float $seuil_min = 90.0): bool {
    $pourcentage = 0.0;

    // Normalisation optionnelle (pour ignorer la casse et les espaces superflus)
    $reponse_norm = trim(strtolower($reponse));
    $input_user_norm = trim(strtolower($input_user));

    // similar_text stocke la similarité en pourcentage dans la variable $pourcentage
    similar_text($reponse_norm, $input_user_norm, $pourcentage);

    return $pourcentage >= $seuil_min;
}

function getRoleFromQuizzId(int $quizzId) {
    $pdo = getDatabaseConnection();
    $stmt = $pdo->prepare("SELECT Role FROM Users JOIN Quizzs ON Users.ID = Quizzs.Creator_id WHERE Quizzs.ID = :quizz_id;");
    $stmt->execute([
        "quizz_id" => $quizzId
    ]);
    return $stmt->fetchColumn();
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

function getAllQuizzs(): array
{
    $pdo = getDatabaseConnection();
    $stmt = $pdo->prepare("SELECT * FROM `Quizzs`");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getQuizzById(int $id): array|bool
{
    $pdo = getDatabaseConnection();
    $stmt = $pdo->prepare("SELECT * FROM `Quizzs` WHERE `id` = :id");
    $stmt->execute([
        "id" => $id,
    ]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function createQuizz(string $name, array $jwt): int
{
    $pdo = getDatabaseConnection();
    $stmt = $pdo->prepare(
        "INSERT INTO `Quizzs` (`Name`, `Creator_id`, `Active`, `Finished`) VALUES (:name, :id, 1,0)",
    );
    $stmt->execute([
        "name" => $name,
        "id" => $jwt["body"]["user_id"],
    ]);
    return $pdo->lastInsertId();
}
?>