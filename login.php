<?php
session_start();
require_once 'includes/db.php';
require_once 'includes/auth_funcs.php';

// If user is already logged in, redirect to dashboard
if (isUserLoggedIn()) {
    header('Location: dashboard.php');
    exit;
}

// Process login if form submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user = verifyLogin($pdo); 
    if ($user) {
        header('Location: dashboard.php');
        exit;
    } else {
        $error = "Invalid credentials";
    }
}
?>

<!--Login Fomr-->
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>
    <link rel="stylesheet" href="styles.css">
    <link href="https://cdn.jsdelivr.net/npm/daisyui@5" rel="stylesheet" type="text/css" />
    <link href="https://cdn.jsdelivr.net/npm/daisyui@5/themes.css" rel="stylesheet" type="text/css" />
</head>
<body>


<!--Create Login form-->
<section class="login-section">
    <div class="login-container">
       <h1 class="login-title">Login Page</h1>
       <label for="email" class="login-label">Email:</label>
         <input type="email" id="email" name="email" class="login-input" required>
       <label for="password" class="login-label">Password:</label>
         <input type="password" id="password" name="password" class="login-input" required>
       <button type="submit" class="login-button">Login</button>
    </div>
</section>

<script src="scripts.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</body>
</html>