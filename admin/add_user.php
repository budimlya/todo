<?php
require_once 'auth.php';

if (isset($_POST['add_user'])) {

    $u = mysqli_real_escape_string($conn, $_POST['username']);
    $p = md5($_POST['password']);
    $r = $_POST['role'];

    mysqli_query($conn,"
        INSERT INTO users (username,password,role)
        VALUES ('$u','$p','$r')
    ");

    header("Location: index.php");
}
