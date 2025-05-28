<?php
session_start();
include('../config/db.php');

// ✅ Cek dua-duanya: username & user_id
if (!isset($_SESSION['username']) || !isset($_SESSION['user_id'])) {
    header('Location: ../login.php');
    exit;
}

if (isset($_POST['submit'])) {
    $nama_tugas = mysqli_real_escape_string($conn, $_POST['nama_tugas']);
    $deskripsi = mysqli_real_escape_string($conn, $_POST['deskripsi']);
    $user_id = $_SESSION['user_id']; // ✅ Ambil ID user dari session

    $query = "INSERT INTO tugas (nama_tugas, deskripsi, user_id) VALUES ('$nama_tugas', '$deskripsi', '$user_id')";

    if (mysqli_query($conn, $query)) {
        header('Location: ../dashboard.php');
        exit;
    } else {
        echo "Gagal menambahkan tugas: " . mysqli_error($conn);
    }
}
?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Tugas</title>
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../style.css?v=<?php echo time(); ?>">

    <style>
    body {
        font-family: 'Orbitron', sans-serif;
        text-align: center;
    }

    form {
        display: inline-block;
        text-align: left;
        margin-top: 20px;
        width: 500px; 
    }

    a {
        display: block;
        margin-top: 20px;
        text-align: center;
        color: blue;
        text-decoration: none;
    }

    a:hover {
        text-decoration: underline;
    }
</style>

</head>
<body>
    <h1>Tambah Tugas</h1>

    <form action="tambah.php" method="POST">
        <label for="nama_tugas">Nama Tugas:</label>
        <input type="text" name="nama_tugas" id="nama_tugas" required><br><br>

        <label for="deskripsi">Deskripsi:</label>
        <textarea name="deskripsi" id="deskripsi" required></textarea><br><br>

        <button type="submit" name="submit">Tambah Tugas</button>
    </form>

    <a href="../dashboard.php">Kembali ke Dashboard</a>
</body>
</html>

