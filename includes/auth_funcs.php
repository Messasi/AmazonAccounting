<?php
// Start session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Check if user is logged in
function isUserLoggedIn() {
    return isset($_SESSION['user_id']);
}

// Require login for protected pages
function requireLogin() {
    if (!isUserLoggedIn()) {
        header('Location: login.php');
        exit;
    }
    // If logged in → allow the page to continue normally
}

// Get current logged-in user details
function getCurrentUser($pdo){
    if (!isUserLoggedIn()) {
        return false;
    }

    $stmt = $pdo->prepare("SELECT * FROM users WHERE id = :id LIMIT 1");
    $stmt->execute(['id' => $_SESSION['user_id']]);

    return $stmt->fetch(PDO::FETCH_ASSOC);
}