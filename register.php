<?php
require_once 'config/db.php';

$message = '';

if (isset($_POST['register'])) {
    $username = $_POST['username'];
    $email    = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Query untuk memasukkan data ke tabel users
    $stmt = $conn->prepare("INSERT INTO users (username, email, password, created_at) VALUES (?, ?, ?, NOW())");
    $stmt->bind_param("sss", $username, $email, $password);
    
    if ($stmt->execute()) {
        $message = "Registrasi berhasil! <a href='login.php'>Lanjut ke halaman login</a>";
    } else {
        $message = "Terjadi kesalahan: " . $stmt->error;
    }
}
?>


<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>">
</head>
<body>

<?php if ($message) echo "<p>$message</p>"; ?>


<form method="POST">
<h2 style="text-align: center;">Form Registrasi</h2>
<div class="input-group">
<div class="input-icon">Username</div>
    <input type="text" name="username" placeholder="Username" required><br>
    <div class="input-group">
    <div class="input-icon">Email</div>
    <input type="email" name="email" placeholder="Email" required><br>
    <div class="input-group">
    <div class="input-icon">Password</div>
    <input type="password" name="password" placeholder="Password" required><br>
    <button type="submit" name="register">Register</button>
    <p style="text-align: center; margin-top: 10px;" >sudah punya akun? <a href="login.php"">login</a></p>
</form>

</body>
</html>
