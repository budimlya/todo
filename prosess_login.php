<?php
session_start();
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD']=='POST') {

    $username = mysqli_real_escape_string($conn,$_POST['username']);
    $password = $_POST['password'];
    $role     = $_POST['role'];

    $sql = "SELECT * FROM users
            WHERE username='$username'
            AND role='$role'";

    $result = mysqli_query($conn,$sql);

    if(mysqli_num_rows($result)==1){

        $user = mysqli_fetch_assoc($result);

        if(md5($password)==$user['password']){

            $_SESSION['login']    = true;
            $_SESSION['user_id']  = $user['id'];
            $_SESSION['username']= $user['username'];
            $_SESSION['role']    = $user['role'];

            if($role=='admin'){
                header("Location: admin/index.php");
            }else{
                header("Location: dashboard.php");
            }

            exit();

        }else{
            header("Location: index.php?mode=$role&error=Password salah");
        }

    }else{
        header("Location: index.php?mode=$role&error=Akun tidak ditemukan");
    }
}