<?php
$host = "localhost";
$port = "5432";
$dbname = "db_laundry";
$user = "postgres";
$password = "211020";

$conn = pg_connect("host=$host port=$port dbname=$dbname user=$user password=$password");

if (!$conn) {
    die("Koneksi PostgreSQL gagal.");
}
?>