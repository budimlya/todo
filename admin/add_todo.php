<?php
require_once 'auth.php';

if (isset($_POST['add_todo'])) {

    $title   = mysqli_real_escape_string($conn,$_POST['title']);
    $user_id = $_POST['user_id'];

    mysqli_query($conn,"
        INSERT INTO todos (user_id,title,status)
        VALUES ('$user_id','$title','pending')
    ");

    header("Location: index.php");
}