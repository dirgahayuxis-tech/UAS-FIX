<?php
session_start();
if (!isset($_SESSION['status_login']) || $_SESSION['status_login'] !== true) {
    echo "<script>alert('Anda harus login terlebih dahulu!'); window.location='login.php';</script>";
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Home - Laundry</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <nav>
        <ul>
            <li><a href="index.php">Home</a></li>
            
            <?php if ($_SESSION['role'] == 'admin') { ?>
                <li><a href="services.php">Services</a></li>
            <?php } ?>
            
            <li><a href="data_pesanan.php">Data Pesanan</a></li>
            <li><a href="pricing.php">Pricing</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </nav>
    <div class="container">
        <h1>Selamat Datang!</h1>
        <p>Anda telah masuk ke sistem manajemen laundry standar. Gunakan menu navigasi di atas untuk menjelajahi fitur.</p>
        <p>Untuk layanan dan lokasi kami, silakan klik tombol di bawah ini:</p>
        <a href="https://www.google.com/maps/place/Pondok+Anugerah+Dua+putra/@-5.2074414,119.501052,19.81z/data=!4m9!1m2!2m1!1slokasi+sekarang!3m5!1s0x2dbee3b139f1b535:0xb0603e5223744dbc!8m2!3d-5.2074618!4d119.5013322!16s%2Fg%2F11t4_kyjj2?entry=ttu&g_ep=EgoyMDI2MDYxNi4wIKXMDSoASAFQAw%3D%3D" class="btn">Lihat Layanan dan lokasi</a>
    </div>
    <div class="container">
        <h2>Informasi Kontak</h2>
        <p>Jika Anda memiliki pertanyaan atau ingin menghubungi kami, silakan gunakan informasi berikut:</p>
        <ul>
            <li><strong>Alamat:</strong> Jln.lurus</li>
            <li><strong>Telepon:</strong> 2,4,4,3,4</li>
            <li><strong>Email:</strong> keyakinanmasingmasing@gmail.com</li>
        </ul>
    </div>
    <div class="footer">
        <style>
            .footer {
                text-align: center;
                padding: 10px;
                background-color: #f1f1f1;
                position: fixed;
                left: 0;
                bottom: 0;
                width: 100%;
                text-align: center;
            }
        </style>    
        <p>&copy; 2024 Dipoy Laundry. All rights reserved.</p>  
    </div>

</body>
</html>