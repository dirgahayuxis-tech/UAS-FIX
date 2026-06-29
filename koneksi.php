<?php
$host = "localhost";
$port = "5432"; 
$dbname = "db_laundry";
$user = "postgres"; 
$password = "211020"; 

$string_koneksi = "host=$host port=$port dbname=$dbname user=$user password=$password";
$koneksi = pg_connect($string_koneksi);

if (!$koneksi) {
    // Menambahkan $koneksi ke dalam parameter untuk mengatasi peringatan VS Code
    die("Koneksi gagal: " . pg_last_error($koneksi));
}
?>