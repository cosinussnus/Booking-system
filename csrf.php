<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

function generateCSRFToken() {
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

function validateCSRFToken($token) {
    if (isset($_SESSION['csrf_token']) && !empty($_SESSION['csrf_token'])) {
        return hash_equals($_SESSION['csrf_token'], $token);
    }
    return false;
}
?>
