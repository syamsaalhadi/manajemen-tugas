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

$query = "DELETE FROM tugas WHERE id = '$id'";
if (mysqli_query($conn, $query)) {
    echo "Tugas berhasil dihapus!";
    header('Location: ../dashboard.php');
    exit;
} else {
    echo "Gagal menghapus tugas: " . mysqli_error($conn);
}
?>
