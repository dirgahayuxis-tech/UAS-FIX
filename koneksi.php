<?php
$database_url = getenv("DATABASE_URL");

if ($database_url) {
    // Koneksi untuk hosting online
    $url = parse_url($database_url);

    $host = $url["host"];
    $port = $url["port"] ?? 5432;
    $dbname = ltrim($url["path"], "/");
    $user = $url["user"];
    $password = $url["pass"];

    $koneksi = pg_connect("host=$host port=$port dbname=$dbname user=$user password=$password sslmode=require");
} else {
    // Koneksi untuk laptop lokal
    $host = "localhost";
    $port = "5432";
    $dbname = "db_laundry";
    $user = "postgres";
    $password = "211020";

    $koneksi = pg_connect("host=$host port=$port dbname=$dbname user=$user password=$password");
}

if (!$koneksi) {
    die("Koneksi PostgreSQL gagal.");
}
?>