<?php

require "models/databaseModel.php";

$error = null;
$success = null;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username'] ?? '');
    $firstname = trim($_POST['firstname'] ?? '');
    $lastname = trim($_POST['lastname'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $role = trim($_POST['role'] ?? '');
    $password = $_POST['password'] ?? '';

    if (empty($username) || empty($firstname) || empty($lastname) || empty($email) || empty($role) || empty($password)) {
        $error = "All fields are required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email format.";
    } elseif (strlen($password) < 8) {
        $error = "Password must be at least 8 characters long.";
    } else {
        $pdo = getDatabaseConnection();
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM Users WHERE Username = ?");
        $stmt->execute([$username]);
        if ($stmt->fetchColumn() > 0) {
            $error = "Username already exists.";
        } else {
            $stmt = $pdo->prepare("SELECT COUNT(*) FROM Users WHERE email = ?");
            $stmt->execute([$email]);
            if ($stmt->fetchColumn() > 0) {
                $error = "Email already exists.";
            } else {
                $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
                $stmt = $pdo->prepare("INSERT INTO Users (Username, Firstname, Lastname, email, Role, Password, active) VALUES (?, ?, ?, ?, ?, ?, 1)");
                
                if ($stmt->execute([$username, $firstname, $lastname, $email, $role, $hashedPassword])) {
                    $success = "Registration successful! You can now log in.";
                } else {
                    $error = "An error occurred during registration. Please try again.";
                }
            }
        }
    }
}

require "views/header.php";
require "views/registerView.php";
require "views/footer.php";