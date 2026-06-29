<?php
session_start();
if (!isset($_SESSION['status_login']) || $_SESSION['status_login'] !== true) {
    echo "<script>alert('Anda harus login terlebih dahulu!'); window.location='login.php';</script>";
    exit;
}
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    echo "<script>alert('Akses Ditolak!'); window.location='index.php';</script>";
    exit;
}

include 'koneksi.php';

if (isset($_POST['submit_pesanan'])) {
    $nama_pelanggan = $_POST['nama_pelanggan'];
    $layanan        = $_POST['layanan'];
    $tanggal_masuk  = $_POST['tanggal_masuk'];
    $paket          = $_POST['paket'];
    $no_hp          = $_POST['no_hp'];
    $total_harga    = $_POST['total_harga'];

    $foto = isset($_FILES['foto']['name']) ? $_FILES['foto']['name'] : "";
    $tmp_foto = isset($_FILES['foto']['tmp_name']) ? $_FILES['foto']['tmp_name'] : "";
    $nama_foto_baru = "";

    if ($foto != "") {
        $nama_foto_baru = rand(1000, 9999) . "_" . $foto;
        $path = "uploads/" . $nama_foto_baru;
        move_uploaded_file($tmp_foto, $path);
    }

    $query_simpan = "INSERT INTO pesanan (nama_pelanggan, jenis_layanan, tanggal_masuk, paket, foto, no_hp, total_harga, status) 
                     VALUES ('$nama_pelanggan', '$layanan', '$tanggal_masuk', '$paket', '$nama_foto_baru', '$no_hp', '$total_harga', 'Diproses')";
    
    $simpan = pg_query($koneksi, $query_simpan);

    if ($simpan) {
        echo "<script>alert('Data pesanan berhasil disimpan!'); window.location='data_pesanan.php';</script>";
    } else {
        echo "<script>alert('Gagal menyimpan data: " . pg_last_error($koneksi) . "');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Services - Tambah Pesanan</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        .container-form {
            max-width: 1000px;
            margin: 40px auto;
            padding: 40px;
            background: #ffffff;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .form-title { text-align: center; color: #2c3e50; margin-bottom: 30px; }

        /* MENGGUNAKAN GRID UNTUK KESEJAJARAN SEMPURNA */
        .laundry-form {
            display: grid;
            grid-template-columns: 250px 1fr; /* Kolom 1 untuk Label, Kolom 2 untuk Input */
            gap: 20px 30px;
            align-items: center;
        }

        .form-group {
            display: contents; /* Membiarkan elemen anak mengikuti grid form */
        }

        label { font-weight: 600; color: #34495e; text-align: right; }

        input[type="text"], input[type="number"], input[type="date"], select {
            width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 6px; box-sizing: border-box;
        }

        .radio-group { display: flex; gap: 20px; }
        
        .button-group { 
            grid-column: span 2; /* Tombol melebar penuh di bawah */
            text-align: center; 
            margin-top: 20px; 
        }

        .btn-simpan { background-color: #3498db; color: white; padding: 10px 40px; border: none; border-radius: 6px; cursor: pointer; }
        .btn-batal { background-color: #e67e22; color: white; padding: 10px 40px; border: none; border-radius: 6px; cursor: pointer; }
    </style>
</head>
<body>
    <nav>
        <ul>
            <li><a href="index.php">Home</a></li>
            <?php if (isset($_SESSION['role']) && $_SESSION['role'] == 'admin') { ?>
                <li><a href="services.php">Services</a></li>
            <?php } ?>
            <li><a href="data_pesanan.php">Data Pesanan</a></li>
            <li><a href="pricing.php">Paket Harga</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </nav>

    <div class="container-form">
        <h2 class="form-title">Tambah Pesanan</h2>
        <form action="" method="POST" class="laundry-form" enctype="multipart/form-data">
            
            <div class="form-group">
                <label>Nama Pelanggan</label>
                <input type="text" name="nama_pelanggan" required>
            </div>

            <div class="form-group">
                <label>No. HP / WhatsApp</label>
                <input type="text" name="no_hp" placeholder="Contoh: 08123456789" required>
            </div>

            <div class="form-group">
                <label>Jenis Layanan</label>
                <div class="radio-group">
                    <input type="radio" name="layanan" value="Kiloan" id="kiloan" required> <label for="kiloan" style="text-align: left;">Kiloan</label>
                    <input type="radio" name="layanan" value="Satuan" id="satuan" required> <label for="satuan" style="text-align: left;">Satuan</label>
                </div>
            </div>

            <div class="form-group">
                <label>Tanggal Masuk</label>
                <input type="date" name="tanggal_masuk" value="<?= date('Y-m-d'); ?>" required>
            </div>

            <div class="form-group">
                <label>Paket</label>
                <select name="paket" required>
                    <option value="">-- Pilih Paket --</option>
                    <option value="Cuci Kering">Cuci Kering</option>
                    <option value="Cuci Setrika">Cuci Setrika</option>
                    <option value="Express (6 Jam)">Express (6 Jam)</option>
                </select>
            </div>

            <div class="form-group">
                <label>Total Harga (Rp)</label>
                <input type="number" name="total_harga" placeholder="Contoh: 45000" required>
            </div>

            <div class="form-group">
                <label>Upload Foto (Opsional)</label>
                <input type="file" name="foto" accept="image/*">
            </div>

            <div class="button-group">
                <button type="submit" name="submit_pesanan" class="btn-simpan">Simpan</button>
                <button type="reset" class="btn-batal">Batal</button>
            </div>
        </form>
    </div>
</body>
</html>