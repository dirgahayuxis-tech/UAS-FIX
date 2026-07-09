<?php
$host = "localhost";
$port = "5432";
$dbname = "db_laundry";
$user = "postgres";
$password = "ISI_PASSWORD_POSTGRES_ANDA";

$string_koneksi = "host=$host port=$port dbname=$dbname user=$user password=$password";

$koneksi = pg_connect($string_koneksi);

if (!$koneksi) {
    die("Koneksi gagal ke database PostgreSQL.");
}
?>