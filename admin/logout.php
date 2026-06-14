<?php
session_start();

// Hapus semua session
$_SESSION = array();

// Hapus session cookie
if (isset($_COOKIE[session_name()])) {
    setcookie(session_name(), '', time() - 42000, '/');
}

// Destroy session
session_destroy();

// Redirect ke login dengan pesan
header("Location: login.php?logout=success");
exit;
?>