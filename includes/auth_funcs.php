<?php
// Start session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/**
 * Check if user is logged in
 * @return bool
 */
function isUserLoggedIn() {
    return isset($_SESSION['user_id']);

}

/**
 * Require login for protected pages
 * Redirects to login if not authenticated
 */
function requireLogin() {
    if (!isUserLoggedIn()) {
        header('Location: login.php');
        exit;
    }else{
        header('Location: dashboard.php');
        exit;
    }
}

/**
 * Get current logged-in user details
 * @param PDO $pdo Database connection
 * @return array|false User data or false
 */
function getCurrentUser($pdo) {
    if (!isUserLoggedIn()) {
        return false;
    }

    try {
        $stmt = $pdo->prepare("SELECT id, name, email FROM users WHERE id = :id LIMIT 1");
        $stmt->execute(['id' => $_SESSION['user_id']]);
        
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
        // If user not found (deleted?), clear session
        if (!$user) {
            session_destroy();
            return false;
        }
        
        return $user;
        
    } catch (PDOException $e) {
        error_log("Database error in getCurrentUser: " . $e->getMessage());
        return false;
    }
}

/**
 * Attempt to log in user
 *@param PDO $pdo Database connection
 * @param string $email User email
 * @param string $password Plain text password
 * @return bool Success/failure
 */
function loginUser($pdo, $email, $password) {
    try {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email LIMIT 1");
        $stmt->execute(['email' => $email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
        // Verify user exists and password matches
        if ($user && password_verify($password, $user['password_hash'])) {
            // SECURITY: Regenerate session ID
            session_regenerate_id(true);
            
            // Set session
            $_SESSION['user_id'] = $user['id'];
            
            return true;
        }
        
        return false;
        
    } catch (PDOException $e) {
        error_log("Database error in loginUser: " . $e->getMessage());
        return false;
    }
}

/**
 * Log out current user
 */
function logoutUser() {
    // Clear all session variables
    $_SESSION = array();
    
    // Delete session cookie
    if (isset($_COOKIE[session_name()])) {
        setcookie(session_name(), '', time() - 3600, '/');
    }
    
    // Destroy session
    session_destroy();
}