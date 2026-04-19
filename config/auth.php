<?php
// config/auth.php

function registerUser($pdo, $name, $email, $password)
{
    $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->execute([$email]);
    if ($stmt->fetch())
        return ['success' => false, 'message' => 'Email already registered.'];

    $hashedPassword = password_hash($password, PASSWORD_BCRYPT, ['cost' => 12]);
    try {
        $stmt = $pdo->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
        $stmt->execute([$name, $email, $hashedPassword]);
        return ['success' => true, 'message' => 'Registration successful! Please login.'];
    } catch (PDOException $e) {
        error_log("Registration Error: " . $e->getMessage());
        return ['success' => false, 'message' => 'Error during registration.'];
    }
}

function loginUser($pdo, $email, $password)
{
    $stmt = $pdo->prepare("SELECT id, name, password FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        session_regenerate_id(true);
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_name'] = $user['name'];
        return ['success' => true];
    }
    return ['success' => false, 'message' => 'Invalid email or password.'];
}

function isLoggedIn()
{
    return isset($_SESSION['user_id']);
}

function logout()
{
    $_SESSION = [];
    session_destroy();
    setcookie(session_name(), '', time() - 3600, '/');
}
?>