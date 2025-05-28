<?php
session_start();
include('config/db.php');

$message = '';       // inisialisasi pesan kosong
$message_type = '';  // inisialisasi tipe pesan

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = mysqli_real_escape_string($conn, $_POST['email']);  // pakai email sesuai form
    $password = $_POST['password'];

    $query = "SELECT * FROM users WHERE email = '$email' LIMIT 1";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) === 1) {
        $user = mysqli_fetch_assoc($result);

        if (password_verify($password, $user['password'])) {
            $_SESSION['username'] = $user['username'];
            $_SESSION['user_id'] = $user['id']; // <-- INI WAJIB ADA
            header('Location: dashboard.php');
            exit;
        }
         else {
            $message = "Password salah!";
            $message_type = "error";
        }
    } else {
        $message = "Email tidak ditemukan!";
        $message_type = "error";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
<link rel="stylesheet" href="style.css?v=<?php echo time(); ?>">
</head>
<body>
    <div class="login-container">
        <!-- Logo dan form -->
        <form method="POST" id="loginForm">
            <!-- Header form -->

            <!-- Tampilkan pesan error -->
            <?php if (!empty($message)): ?>
            <div class="message <?php echo htmlspecialchars($message_type); ?>" style="color:red; margin-bottom: 1rem;">
                <?php echo htmlspecialchars($message); ?>
            </div>
            <?php endif; ?>

            <h2 style="text-align: center;">Form Login</h2>
            <!-- Email input -->
            <div class="input-group">
                <div class="input-icon">Email</div>
                <input type="email" 
                       name="email" 
                       placeholder="Enter your email address" 
                       required 
                       autocomplete="email"
                       value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>">
            </div>

            <!-- Password input -->
            <div class="input-group">
                <div class="input-icon">Password</div>
                <input type="password" 
                       name="password" 
                       placeholder="Enter your password" 
                       required 
                       autocomplete="current-password">
            </div>

            <button type="submit" name="login" id="loginBtn">
                🚀 INITIALIZE CONNECTION
            </button>
            <p style="text-align: center; margin-top: 10px;" >belum punya akun? <a href="register.php"">register</a></p>

            <!-- Footer dan lainnya tetap seperti kode kamu -->
        </form>
    </div>
    <!-- script dan style tetap sama -->
</body>
</html>
