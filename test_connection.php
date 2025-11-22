<?php
$pdo = require __DIR__ . '/includes/db.php';

if ($pdo) {
    echo " Database connection successful!";
} else {
    echo "❌ Database connection failed.";
}