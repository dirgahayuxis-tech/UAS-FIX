<?php
include 'koneksi.php';

// Ambil ID dari link URL
if (!isset($_GET['id'])) {
    exit('Nota Tidak Valid');
}
$id_pesanan = $_GET['id'];

// Ambil data dari database berdasarkan ID
$query = pg_query($koneksi, "SELECT * FROM pesanan WHERE id_pesanan = '$id_pesanan'");
$data = pg_fetch_assoc($query);

if (!$data) {
    die("<h3 style='text-align:center;margin-top:50px;'>Maaf, Nota Digital Tidak Ditemukan.</h3>");
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Nota Digital #<?= $data['id_pesanan']; ?> - Dipoy Laundry</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f7f6;
            margin: 0;
            padding: 20px;
            color: #333;
        }

        .invoice-card {
            max-width: 550px;
            margin: 20px auto;
            background: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            border-top: 8px solid #3498db;
        }

        .header {
            text-align: center;
            margin-bottom: 25px;
        }

        .header h2 {
            margin: 0;
            color: #2c3e50;
            font-size: 24px;
        }

        .header p {
            margin: 5px 0 0;
            color: #7f8c8d;
            font-size: 14px;
        }

        .info-table {
            width: 100%;
            margin-bottom: 25px;
            border-collapse: collapse;
        }

        .info-table td {
            padding: 10px 0;
            border-bottom: 1px dashed #eee;
            font-size: 15px;
        }

        .info-table td.label {
            color: #7f8c8d;
        }

        .info-table td.value {
            text-align: right;
            font-weight: bold;
            color: #2c3e50;
        }

        .total-box {
            background-color: #3498db;
            color: white;
            padding: 15px;
            border-radius: 6px;
            text-align: center;
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 25px;
        }

        /* DESAIN METODE PEMBAYARAN BARU */
        .payment-section h3 {
            text-align: center;
            color: #2c3e50;
            margin-bottom: 15px;
            font-size: 18px;
        }

        .method-card {
            border: 2px solid #eee;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 15px;
            text-align: center;
            transition: 0.3s;
        }

        .method-card.online {
            border-color: #2ecc71;
            background-color: #f9fffb;
        }

        .method-card.offline {
            border-color: #f39c12;
            background-color: #fffcf5;
        }

        .method-card h4 {
            margin: 0 0 10px 0;
            font-size: 18px;
        }

        .method-card.online h4 {
            color: #27ae60;
        }

        .method-card.offline h4 {
            color: #d68910;
        }

        .method-card p {
            font-size: 13px;
            color: #555;
            line-height: 1.5;
            margin-bottom: 15px;
        }

        .qris-img {
            width: 200px;
            border: 1px solid #ddd;
            padding: 10px;
            border-radius: 8px;
            background: #fff;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
        }

        .footer {
            text-align: center;
            margin-top: 25px;
            font-size: 13px;
            color: #95a5a6;
            border-top: 1px solid #eee;
            padding-top: 15px;
        }

        .btn-dana {
            display: inline-block;
            background-color: #118ee9; /* Warna Biru DANA */
            color: white !important;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 8px;
            font-weight: bold;
            margin-top: 15px;
            transition: background-color 0.3s;
            box-shadow: 0 4px 6px rgba(17, 142, 233, 0.3);
        }

        .btn-dana:hover {
            background-color: #0d73be;
        }
    </style>
</head>

<body>

    <div class="invoice-card">
        <div class="header">
            <h2>DIPOY LAUNDRY</h2>
            <p>Nota Pembayaran Digital</p>
        </div>

        <table class="info-table">
            <tr>
                <td class="label">No. Nota</td>
                <td class="value">#LN-<?= $data['id_pesanan']; ?></td>
            </tr>
            <tr>
                <td class="label">Nama Pelanggan</td>
                <td class="value"><?= htmlspecialchars($data['nama_pelanggan']); ?></td>
            </tr>
            <tr>
                <td class="label">Paket Layanan</td>
                <td class="value"><?= $data['jenis_layanan']; ?> - <?= $data['paket']; ?></td>
            </tr>
            <tr>
                <td class="label">Status Cucian</td>
                <td class="value" style="color: #2ecc71;"><?= $data['status']; ?></td>
            </tr>
        </table>

        <div class="total-box">
            Total Tagihan: Rp <?= number_format($data['total_harga'], 0, ',', '.'); ?>
        </div>

        <div class="payment-section">
            <h3>Pilihan Metode Pembayaran</h3>

            <div class="method-card online">
                <h4>📱 Bayar Online (QRIS & DANA)</h4>
                <p>Scan barcode di bawah ini menggunakan aplikasi M-Banking (BCA, BNI, Mandiri) atau e-Wallet favorit Anda.</p>
                
                <?php if (file_exists("qris.jpeg")) { ?>
                    <img src="qris.jpeg" alt="Barcode QRIS Toko" class="qris-img">
                <?php } else { ?>
                    <div style="border: 1px dashed #ccc; padding: 15px; color: gray; font-style: italic; font-size: 13px;">
                        [Gambar qris.jpeg belum di-upload oleh admin]
                    </div>
                <?php } ?>

                <p style="margin-top: 20px; font-size: 13px; color: #555;">Atau bayar instan via aplikasi DANA:</p>
                
                <a href="https://link.dana.id/minta?full_url=https://qr.dana.id/v1/281012012021051349701653 " target="_blank" class="btn-dana">💳 Bayar Pakai DANA</a>
            </div>

            <div class="method-card offline">
                <h4>💵 Bayar Offline (Tunai)</h4>
                <p>Lebih suka bayar tunai? Tidak masalah!<br>Silakan tunjukkan nota digital ini kepada kasir kami saat mengambil pakaian Anda di toko, atau bayar langsung kepada kurir saat pengantaran.</p>
            </div>
        </div>

        <div class="footer">
            Terima kasih atas kepercayaan Anda!<br>Semoga pakaian Anda senantiasa bersih dan wangi.
        </div>
    </div>

</body>

</html>