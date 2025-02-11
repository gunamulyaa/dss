<?php
$host = "localhost";
$port = "5432";
$dbname = "dss_framework";
$user = "postgres";
$password = "yourpassword";

// Membuat koneksi
$conn = pg_connect("host=$host port=$port dbname=$dbname user=$user password=$password");

// Cek koneksi
if (!$conn) {
    die("Koneksi gagal: " . pg_last_error());
}

// Fungsi untuk menambahkan prediksi
function tambahPrediksi($nama_prediksi, $metode) {
    global $conn;
    $result = pg_query_params($conn, "INSERT INTO prediksi (nama_prediksi, metode) VALUES ($1, $2) RETURNING id", array($nama_prediksi, $metode));
    return pg_fetch_result($result, 0, "id");
}

// Fungsi untuk menambahkan kriteria
function tambahKriteria($prediksi_id, $nama, $tipe, $bobot) {
    global $conn;
    $result = pg_query_params($conn, "INSERT INTO kriteria (prediksi_id, nama, tipe, bobot) VALUES ($1, $2, $3, $4) RETURNING id", array($prediksi_id, $nama, $tipe, $bobot));
    return pg_fetch_result($result, 0, "id");
}

// Fungsi untuk menambahkan alternatif
function tambahAlternatif($prediksi_id, $nama) {
    global $conn;
    $result = pg_query_params($conn, "INSERT INTO alternatif (prediksi_id, nama) VALUES ($1, $2) RETURNING id", array($prediksi_id, $nama));
    return pg_fetch_result($result, 0, "id");
}

// Fungsi untuk menambahkan nilai alternatif
function tambahNilaiAlternatif($alternatif_id, $kriteria_id, $nilai) {
    global $conn;
    pg_query_params($conn, "INSERT INTO nilai_alternatif (alternatif_id, kriteria_id, nilai) VALUES ($1, $2, $3)", array($alternatif_id, $kriteria_id, $nilai));
}

// Fungsi untuk menambahkan hasil
function tambahHasil($prediksi_id, $alternatif_id, $skor) {
    global $conn;
    pg_query_params($conn, "INSERT INTO hasil (prediksi_id, alternatif_id, skor) VALUES ($1, $2, $3)", array($prediksi_id, $alternatif_id, $skor));
}

// Fungsi untuk mengambil semua data dari tabel tertentu
function ambilData($tabel) {
    global $conn;
    $result = pg_query($conn, "SELECT * FROM " . pg_escape_identifier($tabel));
    return pg_fetch_all($result);
}

// Tutup koneksi
function tutupKoneksi() {
    global $conn;
    pg_close($conn);
}


?>
