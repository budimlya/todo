<?php
require_once 'auth.php';

if (isset($_GET['start'])) {

    $id = $_GET['start'];

    mysqli_query($conn,"
        UPDATE todos SET status='in_progress'
        WHERE id='$id'
    ");
}

if (isset($_GET['done'])) {

    $id = $_GET['done'];

    mysqli_query($conn,"
        UPDATE todos SET status='completed'
        WHERE id='$id'
    ");
}

header("Location: index.php");
