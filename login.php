<?php
session_start();
include 'koneksi.php';

// Jika sudah login, lempar ke Dashboard (data_pesanan.php)
if (isset($_SESSION['status_login']) && $_SESSION['status_login'] == true) {
    header("Location: data_pesanan.php");
    exit;
}

if (isset($_POST['submit_login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $query = pg_query($koneksi, "SELECT * FROM users WHERE username='$username' AND password='$password'");
    $cek = pg_num_rows($query);

    if ($cek > 0) {
        $data = pg_fetch_assoc($query);
        $_SESSION['id_user'] = $data['id_user'];
        $_SESSION['username'] = $data['username'];
        $_SESSION['role'] = $data['role']; 
        $_SESSION['status_login'] = true;
        
        // Setelah Login Berhasil, arahkan ke data_pesanan.php
        echo "<script>alert('Login Berhasil!'); window.location='index.php';</script>";
    } else {
        echo "<script>alert('Username atau Password salah!'); window.location='login.php';</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login - Dipoy Laundry</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        .login-box { max-width: 300px; margin: 100px auto; padding: 20px; border: 1px solid #ccc; text-align: center; }
        input { width: 90%; margin-bottom: 10px; padding: 8px; }
        button { width: 97%; padding: 10px; background: #2c3e50; color: white; border: none; cursor: pointer; }
    </style>
</head>
<body>
    <div class="login-box">
        <h3>Login Sistem Laundry</h3>
        <form action="" method="POST">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit" name="submit_login">Masuk</button>
        </form>
    </div>
</body>
</html>