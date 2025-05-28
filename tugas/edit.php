<?php
session_start();
include('../config/db.php');

// Cek jika user belum login, redirect ke login
if (!isset($_SESSION['username'])) {
    header('Location: ../login.php');
    exit;
}

// Ambil id tugas dari URL
$id = $_GET['id'];

if (isset($_POST['submit'])) {
    $nama_tugas = mysqli_real_escape_string($conn, $_POST['nama_tugas']);
    $deskripsi = mysqli_real_escape_string($conn, $_POST['deskripsi']);

    $query = "UPDATE tugas SET nama_tugas = '$nama_tugas', deskripsi = '$deskripsi' WHERE id = '$id'";
    if (mysqli_query($conn, $query)) {
        echo "Tugas berhasil diubah!";
        header('Location: ../dashboard.php');
        exit;
    } else {
        echo "Gagal mengubah tugas: " . mysqli_error($conn);
    }
}

// Ambil data tugas yang akan diedit
$query = "SELECT * FROM tugas WHERE id = '$id'";
$result = mysqli_query($conn, $query);
$tugas = mysqli_fetch_assoc($result);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Tugas</title>
    <link rel="stylesheet" href="../style.css?v=<?php echo time(); ?>">
    <style>
            body {
        font-family: 'Orbitron', sans-serif;
        text-align: center;
    }
    </style>
</head>
<body>
    <h1>Edit Tugas</h1>
    <form action="edit.php?id=<?php echo $id; ?>" method="POST">
        <label for="nama_tugas">Nama Tugas:</label>
        <input type="text" name="nama_tugas" id="nama_tugas" value="<?php echo $tugas['nama_tugas']; ?>" required><br><br>

        <label for="deskripsi">Deskripsi:</label>
        <textarea name="deskripsi" id="deskripsi" required><?php echo $tugas['deskripsi']; ?></textarea><br><br>

        <button type="submit" name="submit">Update Tugas</button>
    </form>

    <a href="../dashboard.php">Kembali ke Dashboard</a>
</body>
</html>
