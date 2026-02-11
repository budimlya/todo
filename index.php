<?php
session_start();

$mode = isset($_GET['mode']) ? $_GET['mode'] : 'user';
$error = isset($_GET['error']) ? $_GET['error'] : '';
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Login</title>

<style>
body{
    font-family:Arial;
    background:#f5f5f5;
}

.login-box{
    width:320px;
    background:white;
    margin:120px auto;
    padding:25px;
    border-radius:6px;
    border:1px solid #ddd;
}

input,button{
    width:100%;
    padding:8px;
    margin-bottom:10px;
}

button{
    background:#333;
    color:white;
    border:none;
}

.error{
    background:#ffecec;
    color:red;
    padding:6px;
    margin-bottom:10px;
}
</style>
</head>

<body>

<div class="login-box">

<h2><?= ($mode=='admin')?'Login Admin':'Login User' ?></h2>

<?php if($error): ?>
<div class="error"><?= $error ?></div>
<?php endif; ?>

<form method="POST" action="process_login.php">

<input type="hidden" name="role" value="<?= $mode ?>">

<input type="text" name="username" placeholder="Username" required>

<input type="password" name="password" placeholder="Password" required>

<button type="submit">Login</button>

</form>

<br>

<?php if($mode=='admin'): ?>
<a href="index.php?mode=user">Login User</a>
<?php else: ?>
<a href="index.php?mode=admin">Login Admin</a>
<?php endif; ?>

</div>

</body>
</html>
