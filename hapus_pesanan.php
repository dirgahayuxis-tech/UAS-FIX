<?php
session_start();
if (!isset($_SESSION['status_login']) || $_SESSION['status_login'] !== true) {
    echo "<script>alert('Anda harus login terlebih dahulu!'); window.location='login.php';</script>";
    exit;
}

include 'koneksi.php';

// Menangkap ID yang dikirim dari tombol hapus
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    // Perintah hapus data di PostgreSQL
    $hapus = pg_query($koneksi, "DELETE FROM pesanan WHERE id_pesanan = '$id'");

    if ($hapus) {
        echo "<script>alert('Data pesanan berhasil dihapus!'); window.location='data_pesanan.php';</script>";
    } else {
        echo "<script>alert('Gagal menghapus data!'); window.location='data_pesanan.php';</script>";
    }
}
?>  