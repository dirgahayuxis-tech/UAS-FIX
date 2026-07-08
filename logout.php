<?php
session_start();
session_destroy(); // Menghapus data login
echo "<script>alert('Anda telah berhasil logout!'); window.location='landing-page.php';</script>";
?>