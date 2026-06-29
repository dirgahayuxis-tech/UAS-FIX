<?php
session_start();
if (!isset($_SESSION['status_login']) || $_SESSION['status_login'] !== true) {
    echo "<script>alert('Anda harus login terlebih dahulu!'); window.location='login.php';</script>";
    exit;
}
include 'koneksi.php';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Data Pesanan - Laundry</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        /* Mengatur agar container penuh layar */
        .container-fluid {
            width: 100%;
            padding-right: 30px;
            padding-left: 30px;
            margin-right: auto;
            margin-left: auto;
        }

        .styled-table {
            border-collapse: collapse;
            margin: 25px 0;
            font-size: 0.9em;
            font-family: sans-serif;
            width: 100%; /* Memastikan tabel memenuhi kontainer */
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.15);
            border-radius: 8px;
            overflow: hidden;
        }
        .styled-table thead th {
            background-color: #2c3e50 !important;
            color: #ffffff !important;
            text-align: left;
        }
        .styled-table th,
        .styled-table td {
            padding: 12px 15px;
            border-bottom: 1px solid #dddddd;
            color: #333333;
            vertical-align: middle;
        }
        .styled-table tbody tr {
            transition: all 0.2s ease-in-out;
        }
        .styled-table tbody tr:hover {
            background-color: #f1f8ff;
        }
        .btn-edit {
            display: inline-block; margin: 4px 2px; color: white !important; 
            background-color: #f39c12; padding: 6px 12px; text-decoration: none; border-radius: 4px; font-size: 14px;
        }
        .btn-hapus {
            display: inline-block; margin: 4px 2px; color: white !important; 
            background-color: #e74c3c; padding: 6px 12px; text-decoration: none; border-radius: 4px; font-size: 14px;
        }
        .btn-selesai {
            display: inline-block; margin: 4px 2px; color: white !important; 
            background-color: #2ecc71; padding: 6px 12px; text-decoration: none; border-radius: 4px; font-size: 14px;
            font-weight: bold;
        }
        .btn-selesai:hover { background-color: #27ae60; }
        .badge {
            padding: 4px 8px; border-radius: 4px; font-size: 12px; font-weight: bold; color: white;
        }
        .badge-proses { background-color: #3498db; }
        .badge-selesai { background-color: #2ecc71; }
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
            <li><a href="pricing.php">Pricing</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </nav>

    <div class="container-fluid">
        <h2>Daftar Pesanan Masuk</h2>
        <table class="styled-table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Pelanggan</th>
                    <th>Layanan</th>
                    <th>Tanggal Masuk</th>
                    <th>Paket</th>
                    <th>Total Harga</th>
                    <th>Foto</th>
                    <th>Status</th> 
                    <?php if (isset($_SESSION['role']) && $_SESSION['role'] == 'admin') { ?>
                        <th>Aksi</th>
                    <?php } ?>
                </tr>
            </thead>
            <tbody>
                <?php
                $query = pg_query($koneksi, "SELECT * FROM pesanan ORDER BY id_pesanan DESC");
                $no = 1;
                while ($data = pg_fetch_assoc($query)) {
                ?>
                <tr>
                    <td><?= $no++; ?></td>
                    <td><?= htmlspecialchars($data['nama_pelanggan']); ?></td>
                    <td><?= $data['jenis_layanan']; ?></td>
                    <td><?= $data['tanggal_masuk']; ?></td>
                    <td><?= $data['paket']; ?></td>
                    <td>Rp <?= number_format($data['total_harga'], 0, ',', '.'); ?></td>
                    <td>
                        <?php if (!empty($data['foto'])) { ?>
                            <img src="uploads/<?= $data['foto']; ?>" alt="Foto" width="70" style="border-radius: 4px; border: 1px solid #ccc;">
                        <?php } else { ?>
                            <span style="color: gray; font-style: italic; font-size: 0.85em;">Tidak ada foto</span>
                        <?php } ?>
                    </td>
                    <td>
                        <?php if($data['status'] == 'Selesai') { ?>
                            <span class="badge badge-selesai">Selesai</span>
                        <?php } else { ?>
                            <span class="badge badge-proses">Diproses</span>
                        <?php } ?>
                    </td>
                    
                    <?php if (isset($_SESSION['role']) && $_SESSION['role'] == 'admin') { ?>
                        <td>
                            <?php if($data['status'] !== 'Selesai') { ?>
                                <a href="kirim_wa.php?id=<?= $data['id_pesanan']; ?>" class="btn-selesai">Selesai</a>
                            <?php } ?>
                            <a href="edit_pesanan.php?id=<?= $data['id_pesanan']; ?>" class="btn-edit">Edit</a>
                            <a href="hapus_pesanan.php?id=<?= $data['id_pesanan']; ?>" 
                               onclick="return confirm('Apakah Anda yakin ingin menghapus?');" 
                               class="btn-hapus">Hapus</a>
                        </td>
                    <?php } ?>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</body>
</html>