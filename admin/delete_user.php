<?php
require_once 'auth.php';

if (isset($_GET['id'])) {

    $id = $_GET['id'];

    mysqli_query($conn,"DELETE FROM todos WHERE user_id='$id'");
    mysqli_query($conn,"DELETE FROM users WHERE id='$id'");

    header("Location: index.php");
}
