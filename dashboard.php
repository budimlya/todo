<?php
session_start();
require_once 'config.php';

/* Proteksi User */
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'user') {
    header("Location: index.php?mode=user");
    exit();
}

$user_id = $_SESSION['user_id'];


/* =================
   TAMBAH TODO
================= */
if (isset($_POST['add'])) {

    $title = mysqli_real_escape_string($conn, $_POST['title']);

    mysqli_query($conn,"
        INSERT INTO todos (user_id,title,status)
        VALUES ('$user_id','$title','pending')
    ");
}


/* =================
   PROSES STATUS
================= */

// Pending → In Progress
if (isset($_GET['start'])) {

    $id = $_GET['start'];

    mysqli_query($conn,"
        UPDATE todos 
        SET status='in_progress'
        WHERE id='$id' AND user_id='$user_id'
    ");
}


// In Progress → Completed
if (isset($_GET['done'])) {

    $id = $_GET['done'];

    mysqli_query($conn,"
        UPDATE todos 
        SET status='completed'
        WHERE id='$id' AND user_id='$user_id'
    ");
}



/* =================
   HAPUS TODO
================= */

if (isset($_GET['del'])) {

    $id = $_GET['del'];

    mysqli_query($conn,"
        DELETE FROM todos 
        WHERE id='$id' AND user_id='$user_id'
    ");
}


/* =================
   AMBIL DATA
================= */

$todos = mysqli_query($conn,"
    SELECT * FROM todos 
    WHERE user_id='$user_id'
    ORDER BY id DESC
");

?>

<!DOCTYPE html>
<html>
<head>
<title>Dashboard User</title>

<style>

body{
    font-family:Arial;
    background:#f4f6f9;
}

.container{
    width:90%;
    margin:auto;
}

header{
    background:#333;
    color:white;
    padding:15px;
}

.logout{
    float:right;
    color:red;
}

.box{
    background:white;
    padding:15px;
    margin-top:20px;
    border:1px solid #ccc;
}

input{
    padding:6px;
    width:70%;
}

button{
    padding:6px 10px;
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

.completed{
    text-decoration:line-through;
    color:gray;
}

.progress{
    color:orange;
    font-weight:bold;
}

</style>
</head>

<body>

<header>
Dashboard User - <?= $_SESSION['username'] ?>
<a href="logout.php" class="logout">Logout</a>
</header>

<div class="container">


<!-- FORM TAMBAH -->
<div class="box">

<h3>Tambah Tugas</h3>

<form method="POST">

<input type="text" name="title" placeholder="Tugas baru..." required>

<button name="add">Tambah</button>

</form>

</div>


<!-- LIST -->
<div class="box">

<h3>Daftar Tugas</h3>

<table>

<tr>
<th>No</th>
<th>Tugas</th>
<th>Status</th>
<th>Aksi</th>
</tr>

<?php $no=1; while($t=mysqli_fetch_assoc($todos)): ?>

<tr>

<td><?= $no++ ?></td>

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

<a href="?start=<?= $t['id'] ?>">▶ Mulai</a> |

<?php endif; ?>


<?php if($t['status']=='in_progress'): ?>

<a href="?done=<?= $t['id'] ?>">✔ Selesai</a> |

<?php endif; ?>


<a href="?del=<?= $t['id'] ?>"
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
