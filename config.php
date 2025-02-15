<?php
$host = "localhost";
$port = "5432";
$dbname = "dss-db";
$user = "postgres";
$password = "010302";

// Membuat koneksi
$conn = pg_connect("host=$host port=$port dbname=$dbname user=$user password=$password");

// Cek koneksi
if (!$conn) {
    die("Koneksi gagal: " . pg_last_error());
}


?>
