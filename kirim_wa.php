<?php
session_start();
if (!isset($_SESSION['status_login']) || $_SESSION['role'] !== 'admin') {
    exit('Akses Ditolak');
}
include 'koneksi.php';

$id_pesanan = $_GET['id'];

// 1. Ambil data pelanggan terlebih dahulu
$query_ambil = pg_query($koneksi, "SELECT * FROM pesanan WHERE id_pesanan = '$id_pesanan'");
$data = pg_fetch_assoc($query_ambil);

if ($data) {
    // 2. Update status pesanan menjadi 'Selesai' di database
    pg_query($koneksi, "UPDATE pesanan SET status = 'Selesai' WHERE id_pesanan = '$id_pesanan'");

    // 3. Format nomor HP (Ubah angka 0 di depan nomor HP menjadi 62 untuk standar WhatsApp internasional)
    $no_hp = $data['no_hp'];
    if (substr($no_hp, 0, 1) === '0') {
        $no_hp = '62' . substr($no_hp, 1);
    }

    // 4. Susun Teks Pesanan WhatsApp otomatis
    $nama     = $data['nama_pelanggan'];
    $paket    = $data['paket'];
    $total    = number_format($data['total_harga'], 0, ',', '.');
    

    $link_invoice = "https://gusto-guacamole-untamed.ngrok-free.dev/uts/invoice.php?id=" . $id_pesanan;

    $pesan = "Halo Kak *{$nama}*,\n\nKami dari *Dipoy Laundry* ingin mengabarkan bahwa cucian paket *{$paket}* Kakak sudah *SELESAI* dan siap diambil/diantar! 🎉\n\nTotal Tagihan: *Rp {$total}*\nUntuk melihat rincian nota serta pembayaran via QRIS, silakan klik tautan resmi di bawah ini:\n{$link_invoice}\n\nTerima kasih banyak telah mempercayakan pakaian Kakak kepada kami! 🙏";

    // Ubah format teks biasa menjadi format link URL yang valid
    $pesan_url = urlencode($pesan);

    // Redirect otomatis mengarahkan browser admin membuka WhatsApp Web / Aplikasi WA
    header("Location: https://wa.me/{$no_hp}?text={$pesan_url}");
    exit;
} else {
    echo "<script>alert('Data tidak ditemukan!'); window.location='data_pesanan.php';</script>";
}
?>