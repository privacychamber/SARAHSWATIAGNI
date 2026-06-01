<?php
/**
 * Admin Session Destruction
 */
require_once __DIR__ . '/../includes/functions.php';

// Wipe session arrays
$_SESSION = [];

// Destroy session cookies
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Destroy session file
session_destroy();

header("Location: login.php");
exit;
