<?php
session_start();
require_once '../config.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: ../index.php?mode=admin");
    exit();
}

$admin_id = $_SESSION['user_id'] ?? 0;
