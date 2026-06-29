<?php
session_start();

// 1. Proteksi Keamanan: Hanya admin yang boleh mengakses
if (!isset($_SESSION['status_login']) || $_SESSION['status_login'] !== true) {
    echo "<script>alert('Anda harus login!'); window.location='login.php';</script>";
    exit;
}
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    echo "<script>alert('Akses Ditolak!'); window.location='index.php';</script>";
    exit;
}

include 'koneksi.php';

// 2. Ambil ID pesanan dari URL
$id_pesanan = $_GET['id'];

// Ambil data pesanan yang lama dari database untuk ditampilkan di form
$query_lama = pg_query($koneksi, "SELECT * FROM pesanan WHERE id_pesanan = '$id_pesanan'");
$data_lama = pg_fetch_assoc($query_lama);

// 3. Logika ketika tombol "Update" ditekan
if (isset($_POST['update_pesanan'])) {
    $nama_pelanggan = $_POST['nama_pelanggan'];
    $no_hp          = $_POST['no_hp']; // Tambahan ambil No HP
    $layanan        = $_POST['layanan'];
    $tanggal_masuk  = $_POST['tanggal_masuk'];
    $paket          = $_POST['paket'];
    $total_harga    = $_POST['total_harga']; // Tambahan ambil Total Harga

    // Cek apakah admin mengupload foto baru
    $foto = isset($_FILES['foto']['name']) ? $_FILES['foto']['name'] : "";
    $tmp_foto = isset($_FILES['foto']['tmp_name']) ? $_FILES['foto']['tmp_name'] : "";
    
    // Secara default, kita anggap admin TIDAK ganti foto, jadi pakai nama foto lama
    $nama_foto_baru = $data_lama['foto']; 

    // TETAPI, Jika admin mengupload foto baru, ubah nama fotonya
    if($foto != "") {
        $nama_foto_baru = rand(1000,9999) . "_" . $foto;
        $path = "uploads/" . $nama_foto_baru;
        move_uploaded_file($tmp_foto, $path);
    }

    // Perintah SQL untuk UPDATE data termasuk no_hp dan total_harga
    $query_update = "UPDATE pesanan SET 
                        nama_pelanggan = '$nama_pelanggan', 
                        no_hp = '$no_hp',
                        jenis_layanan = '$layanan', 
                        tanggal_masuk = '$tanggal_masuk', 
                        paket = '$paket', 
                        total_harga = '$total_harga',
                        foto = '$nama_foto_baru' 
                     WHERE id_pesanan = '$id_pesanan'";
    
    $update = pg_query($koneksi, $query_update);

    if ($update) {
        echo "<script>alert('Data pesanan berhasil diubah!'); window.location='data_pesanan.php';</script>";
    } else {
        echo "<script>alert('Gagal mengubah data: " . pg_last_error($koneksi) . "');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Pesanan - Laundry</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <nav>
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="services.php">Services</a></li>
            <li><a href="data_pesanan.php">Data Pesanan</a></li>
            <li><a href="pricing.php">Pricing</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </nav>

    <div class="container-form">
        <h2 class="form-title">Edit Pesanan</h2>
        <hr>

        <form action="" method="POST" class="laundry-form" enctype="multipart/form-data">
            
            <div class="form-group">
                <label>Nama Pelanggan</label>
                <div class="input-col">
                    <input type="text" name="nama_pelanggan" value="<?= $data_lama['nama_pelanggan']; ?>" required>
                </div>
            </div>

            <div class="form-group">
                <label>No. HP / WhatsApp</label>
                <div class="input-col">
                    <input type="text" name="no_hp" value="<?= $data_lama['no_hp']; ?>" required>
                </div>
            </div>

            <div class="form-group">
                <label>Jenis Layanan</label>
                <div class="input-col radio-group">
                    <input type="radio" name="layanan" value="Kiloan" id="kiloan" <?= ($data_lama['jenis_layanan'] == 'Kiloan') ? 'checked' : ''; ?> required> <label for="kiloan" class="label-inline">Kiloan</label>
                    <input type="radio" name="layanan" value="Satuan" id="satuan" <?= ($data_lama['jenis_layanan'] == 'Satuan') ? 'checked' : ''; ?> required> <label for="satuan" class="label-inline">Satuan</label>
                </div>
            </div>

            <div class="form-group">
                <label>Tanggal Masuk</label>
                <div class="input-col">
                    <input type="date" name="tanggal_masuk" value="<?= $data_lama['tanggal_masuk']; ?>" required>
                </div>
            </div>

            <div class="form-group">
                <label>Paket</label>
                <div class="input-col">
                    <select name="paket" required>
                        <option value="Cuci Kering" <?= ($data_lama['paket'] == 'Cuci Kering') ? 'selected' : ''; ?>>Cuci Kering</option>
                        <option value="Cuci Setrika" <?= ($data_lama['paket'] == 'Cuci Setrika') ? 'selected' : ''; ?>>Cuci Setrika</option>
                        <option value="Express (6 Jam)" <?= ($data_lama['paket'] == 'Express (6 Jam)') ? 'selected' : ''; ?>>Express (6 Jam)</option>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label>Total Harga (Rp)</label>
                <div class="input-col">
                    <input type="number" name="total_harga" value="<?= $data_lama['total_harga']; ?>" required>
                </div>
            </div>

            <div class="form-group">
                <label>Ganti Foto (Opsional)</label>
                <div class="input-col">
                    <?php if (!empty($data_lama['foto'])) { ?>
                        <p style="font-size: 13px; margin-bottom: 5px; color: #555;">Foto saat ini:</p>
                        <img src="uploads/<?= $data_lama['foto']; ?>" width="100" style="margin-bottom: 10px; border-radius:4px;"><br>
                    <?php } ?>
                    <input type="file" name="foto" accept="image/*">
                    <p style="font-size: 12px; color: gray; margin-top: 5px;">Biarkan kosong jika tidak ingin mengganti foto.</p>
                </div>
            </div>
            
            <div class="button-group">
                <button type="submit" name="update_pesanan" class="btn-simpan" style="background-color: #01542c;">Update Data</button>
                <a href="data_pesanan.php" class="btn-batal" style="text-align: center; display: inline-block;">Batal</a>
            </div>
        </form>
    </div>
</body>
</html>