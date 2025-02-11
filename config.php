<?php
$host = "localhost";
$port = "5432";
$dbname = "dss";
$user = "postgres";
$password = "010302";

// Membuat koneksi
$conn = pg_connect("host=$host port=$port dbname=$dbname user=$user password=$password");

// Cek koneksi
if (!$conn) {
    die("Koneksi gagal: " . pg_last_error());
}

// SQL untuk membuat tabel
$sql = "CREATE TABLE IF NOT EXISTS prediksi (
    id SERIAL PRIMARY KEY,
    nama_prediksi VARCHAR(255) NOT NULL,
    metode VARCHAR(50) NOT NULL
);

CREATE TABLE IF NOT EXISTS kriteria (
    id SERIAL PRIMARY KEY,
    prediksi_id INT,
    nama VARCHAR(255) NOT NULL,
    tipe VARCHAR(10) CHECK (tipe IN ('benefit', 'cost')) NOT NULL,
    bobot FLOAT NOT NULL,
    FOREIGN KEY (prediksi_id) REFERENCES prediksi(id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS alternatif (
    id SERIAL PRIMARY KEY,
    prediksi_id INT,
    nama VARCHAR(255) NOT NULL,
    FOREIGN KEY (prediksi_id) REFERENCES prediksi(id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS nilai_alternatif (
    id SERIAL PRIMARY KEY,
    alternatif_id INT,
    kriteria_id INT,
    nilai FLOAT NOT NULL,
    FOREIGN KEY (alternatif_id) REFERENCES alternatif(id) ON DELETE CASCADE,
    FOREIGN KEY (kriteria_id) REFERENCES kriteria(id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS hasil (
    id SERIAL PRIMARY KEY,
    prediksi_id INT,
    alternatif_id INT,
    skor FLOAT NOT NULL,
    FOREIGN KEY (prediksi_id) REFERENCES prediksi(id) ON DELETE CASCADE,
    FOREIGN KEY (alternatif_id) REFERENCES alternatif(id) ON DELETE CASCADE
);";

$result = pg_query($conn, $sql);

if ($result) {
    echo "Tabel berhasil dibuat atau sudah ada.";
} else {
    echo "Error membuat tabel: " . pg_last_error($conn);
}

pg_close($conn);
?>
