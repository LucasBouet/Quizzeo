<?php

require "models/databaseModel.php";
require "models/jwt.php";
require "models/createModel.php";

$error = null;
$success = null;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if (empty($username) || empty($password)) {
        $error = "Username and password are required.";
    } else {
        $pdo = getDatabaseConnection();
        
        $stmt = $pdo->prepare("SELECT ID, Username, Role, Password, active FROM Users WHERE Username = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$user) {
            $error = "Invalid username or password.";
        } elseif (!$user['active']) {
            $error = "Your account is inactive.";
        } elseif (!password_verify($password, $user['Password'])) {
            $error = "Invalid username or password.";
        } else {
            $jwtHelper = new JWT();
            $token = $jwtHelper->encode(['user_id' => $user['ID'], 'username' => $user['Username'], 'role' => $user['Role']]);
            setcookie("auth_token", $token, time() + 3600, "/", "", false, true); // 1 hour expiry
            $success = "Login successful! Redirecting...";
            header("refresh:2;url=/");
        }
    }
}

require "views/header.php";
require "views/loginView.php";
require "views/footer.php";