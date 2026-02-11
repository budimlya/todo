<?php
session_start();

if(!isset($_SESSION['login']) || $_SESSION['role']!='user'){
    header("Location: index.php");
    exit();
}