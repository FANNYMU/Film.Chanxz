<?php
session_start();
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Lakukan validasi data
    if (empty($username) || empty($email) || empty($password)) {
        echo "All fields are required.";
    } else {
        // Periksa apakah email sudah terdaftar
        $stmt = $pdo->prepare('SELECT * FROM users WHERE email = ?');
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if ($user) {
            echo "Email already registered.";
        } else {
            // Enkripsi password
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Simpan informasi pengguna ke dalam database
            $stmt = $pdo->prepare('INSERT INTO users (username, email, password) VALUES (?, ?, ?)');
            $stmt->execute([$username, $email, $hashed_password]);

            echo "Registration successful. You can now login.";
        }
    }
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
</head>
<style>
        body {
        background-color: #0f0f0f;
        color: #ffffff;
    }

    .register {
        justify-content:  center ;
        display: grid;
    }
</style>
<body>

    <!-- Tambahkan tombol untuk membuka sidebar -->
    <div class="container-fluid">
        <span style="font-size:30px;cursor:pointer;color:white" onclick="openNav()">&#9776;</span>
    </div>

    <!-- Sertakan sidebar.php di sini -->
    <?php include './sideBar/sidebar.php'; ?>

    <form class="register" action="register.php" method="post">
        <h1>Register</h1>
        <label for="username">Username:</label><br>
        <input type="text" id="username" name="username" required><br>
        <label for="email">Email:</label><br>
        <input type="email" id="email" name="email" required><br>
        <label for="password">Password:</label><br>
        <input type="password" id="password" name="password" required><br>
        <input type="submit" value="Register">
        <p>Sudah Punya Akun. <a href="login.php">Login</a></p>
    </form>
</body>
</html>
