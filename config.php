<?php
$host = "autorack.proxy.rlwy.net";
$port = "42108";
$dbname = "railway";
$user = "postgres";
$password = "OUCHgADVOdfsEdrWFeUZFFjbcbgFfjIA";

// Membuat koneksi
$conn = pg_connect("host=$host port=$port dbname=$dbname user=$user password=$password");

// Cek koneksi
if (!$conn) {
    die("Koneksi gagal: " . pg_last_error());
}

pg_close($conn);
?>
