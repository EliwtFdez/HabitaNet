<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function isLoggedIn() {
    return isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true;
}

function getUserRole() {
    return strtolower(trim($_SESSION['user_role'] ?? ''));
}

function isComite() {
    return getUserRole() === 'comite';
}

function isInquilino() {
    return getUserRole() === 'inquilino';
}
