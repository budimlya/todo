<?php
require_once 'auth.php';

/* =====================
   AMBIL DATA
===================== */

$users = mysqli_query($conn,"
    SELECT * FROM users
    ORDER BY id DESC
");

$todos = mysqli_query($conn,"
    SELECT todos.*, users.username
    FROM todos
    JOIN users ON todos.user_id = users.id
    ORDER BY todos.id DESC
");
?>

<!DOCTYPE html>
<html>
<head>
<title>Dashboard Admin</title>

<style>

body{
    font-family:Arial;
    background:#f4f6f9;
}

.container{
    width:95%;
    margin:auto;
}

h2{
    background:#222;
    color:white;
    padding:15px;
}

.logout{
    float:right;
    color:red;
    text-decoration:none;
}

.box{
    background:white;
    padding:15px;
    margin:20px 0;
    border:1px solid #ccc;
}

input,select{
    padding:6px;
    margin:5px;
}

button{
    padding:6px 12px;
    cursor:pointer;
}

table{
    width:100%;
    border-collapse:collapse;
}

th,td{
    border:1px solid #ccc;
    padding:8px;
    text-align:center;
}

th{
    background:#eee;
}

.completed{
    color:gray;
    text-decoration:line-through;
}

.progress{
    color:orange;
    font-weight:bold;
}

</style>
</head>

<body>

<div class="container">

<h2>
Dashboard Admin
<a href="../logout.php" class="logout">Logout</a>
</h2>

<p>Login sebagai: <b><?= $_SESSION['username'] ?></b></p>


<!-- ================= USER ================= -->

<div class="box">

<h3>Kelola User</h3>

<form method="POST" action="add_user.php">

<input type="text" name="username" placeholder="Username" required>

<input type="password" name="password" placeholder="Password" required>

<select name="role">
    <option value="user">User</option>
    <option value="admin">Admin</option>
</select>

<button name="add_user">Tambah</button>

</form>

<br>

<table>

<tr>
<th>No</th>
<th>Username</th>
<th>Role</th>
<th>Aksi</th>
</tr>

<?php $no=1; while($u=mysqli_fetch_assoc($users)): ?>

<tr>

<td><?= $no++ ?></td>
<td><?= $u['username'] ?></td>
<td><?= $u['role'] ?></td>

<td>

<?php if($u['id'] != $admin_id): ?>

<a href="delete_user.php?id=<?= $u['id'] ?>"
onclick="return confirm('Hapus user?')">
Hapus
</a>

<?php else: ?>

-

<?php endif; ?>

</td>

</tr>

<?php endwhile; ?>

</table>

</div>



<!-- ================= TODO ================= -->

<div class="box">

<h3>ToDo List</h3>


<!-- Tambah -->
<form method="POST" action="add_todo.php">

<select name="user_id" required>

<option value="">-- Pilih User --</option>

<?php
$u2 = mysqli_query($conn,"SELECT * FROM users WHERE role='user'");
while($x=mysqli_fetch_assoc($u2)):
?>

<option value="<?= $x['id'] ?>">
<?= $x['username'] ?>
</option>

<?php endwhile; ?>

</select>

<input type="text" name="title" placeholder="Judul tugas" required>

<button name="add_todo">Tambah</button>

</form>

<br>

<table>

<tr>
<th>No</th>
<th>User</th>
<th>Tugas</th>
<th>Status</th>
<th>Aksi</th>
</tr>


<?php $no=1; while($t=mysqli_fetch_assoc($todos)): ?>

<tr>

<td><?= $no++ ?></td>

<td><?= $t['username'] ?></td>

<td class="
<?=
($t['status']=='completed')?'completed':
(($t['status']=='in_progress')?'progress':'')
?>
">
<?= $t['title'] ?>
</td>


<td>

<?php
if($t['status']=='pending'){
    echo "Pending";
}elseif($t['status']=='in_progress'){
    echo "Proses";
}else{
    echo "Selesai";
}
?>

</td>


<td>

<?php if($t['status']=='pending'): ?>

<a href="update_todo.php?start=<?= $t['id'] ?>">▶ Mulai</a> |

<?php endif; ?>


<?php if($t['status']=='in_progress'): ?>

<a href="update_todo.php?done=<?= $t['id'] ?>">✔ Selesai</a> |

<?php endif; ?>


<a href="delete_todo.php?id=<?= $t['id'] ?>"
onclick="return confirm('Hapus tugas?')">
Hapus
</a>

</td>

</tr>

<?php endwhile; ?>


</table>

</div>


</div>

</body>
</html>