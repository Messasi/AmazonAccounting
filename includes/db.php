<?php

//includes/db.php
//Database connection script

$config = require 'config/database.php';

try {

    $dsn = "mysql:host={$config['host']};dbname={$config['dbname']};charset=utf8mb4";
    $pdo = new PDO($dsn, $config['username'], $config['password']);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // Return or make global
    return $pdo;
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}