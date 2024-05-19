<?php
session_start();
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Cari pengguna berdasarkan email
    $stmt = $pdo->prepare('SELECT * FROM users WHERE email = ?');
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    // Periksa apakah pengguna ditemukan dan password cocok
    if ($user && password_verify($password, $user['password'])) {
        // Autentikasi berhasil, set session dan arahkan ke halaman terproteksi
        $_SESSION['user_id'] = $user['id'];
        header('Location: index.php');
        exit;
    } else {
        // Autentikasi gagal
        echo "Invalid email or password.";
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<style>
    body {
        background-color: #0f0f0f;
        color: #ffffff;
    }

    .login {
        display: grid;
        justify-content:  center ;

    }
</style>
<body>

    <!-- Tambahkan tombol untuk membuka sidebar -->
    <div class="container-fluid">
        <span style="font-size:30px;cursor:pointer;color:white" onclick="openNav()">&#9776;</span>
    </div>

        <!-- Sertakan sidebar.php di sini -->
    <?php include './sideBar/sidebar.php'; ?>

    <form class="login" action="login.php" method="post">
        <h1>Login</h1>
        <label for="email">Email:</label><br>
        <input type="email" id="email" name="email" required><br>
        <label for="password">Password:</label><br>
        <input type="password" id="password" name="password" required><br>
        <input type="submit" value="Login">
        <p>Belom Punya Akun. <a href="register.php">Sig up</a></p>
    </form>
</body>
</html>
