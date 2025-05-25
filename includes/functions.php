<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!function_exists('is_logged_in')) {
    function is_logged_in() {
        return isset($_SESSION['hasta_id']);
    }
}

if (!function_exists('get_logged_in_user_id')) {
    function get_logged_in_user_id() {
        return $_SESSION['hasta_id'] ?? null;
    }
}
?>
