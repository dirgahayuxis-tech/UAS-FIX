<?php
// Ini adalah kode untuk MELINDUNGI halaman (bukan logout)
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
    <title>Pricing - Laundry</title>
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
            <li><a href="pricing.php">Paket Harga</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </nav>
    <div class="container">
        <h2>Daftar Harga</h2>
        <table>
            <tr><th>Item</th><th>Harga</th></tr>
            <tr><td>Cuci Kiloan</td><td>Rp 7.000 /kg</td></tr>
            <tr><td>Cuci Setrika</td><td>Rp 10.000 /kg</td></tr>
            <tr><td>Jas Seluruh</td><td>Rp 25.000 /pcs</td></tr>
        </table>
    </div>
</body>
</html>