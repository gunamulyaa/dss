<?php
$conn = pg_connect("host=autorack.proxy.rlwy.net dbname=railway user=postgres password=OUCHgADVOdfsEdrWFeUZFFjbcbgFfjIA"); // Koneksi ke database PostgreSQL

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id']; // ID utama prediksi
    $nama_prediksi = $_POST['nama_prediksi'];
    $metode = $_POST['metode'];

    // Data tambahan dari kriteria, alternatif, dan nilai alternatif
    $kriteria = $_POST['kriteria']; // Array kriteria
    $alternatif = $_POST['alternatif']; // Array alternatif
    $nilai_alternatif = $_POST['nilai_alternatif']; // Array nilai alternatif

    // Pastikan data tidak kosong
    if (!empty($id) && !empty($nama_prediksi) && !empty($metode)) {
        // Mulai transaksi untuk memastikan atomicity
        pg_query($conn, "BEGIN");

        // Update tabel prediksi
        $query_prediksi = "UPDATE prediksi SET nama_prediksi = $1, metode = $2 WHERE id = $3";
        $result_prediksi = pg_query_params($conn, $query_prediksi, array($nama_prediksi, $metode, $id));

        // Update tabel kriteria
        foreach ($kriteria as $id_kriteria => $bobot) {
            $query_kriteria = "UPDATE kriteria SET bobot = $1 WHERE id = $2";
            pg_query_params($conn, $query_kriteria, array($bobot, $id_kriteria));
        }

        // Update tabel alternatif
        foreach ($alternatif as $id_alternatif => $nama_alternatif) {
            $query_alternatif = "UPDATE alternatif SET nama = $1 WHERE id = $2";
            pg_query_params($conn, $query_alternatif, array($nama_alternatif, $id_alternatif));
        }

        // Update tabel nilai_alternatif
        foreach ($nilai_alternatif as $id_nilai => $nilai) {
            $query_nilai = "UPDATE nilai_alternatif SET nilai = $1 WHERE id = $2";
            pg_query_params($conn, $query_nilai, array($nilai, $id_nilai));
        }

        // Jika semua query berhasil, commit transaksi
        pg_query($conn, "COMMIT");

        echo "<script>
            alert('Data berhasil diperbarui!');
            window.location.href = '../metadata.php';
        </script>";
    } else {
        // Jika ada field kosong, rollback transaksi dan tampilkan pesan error
        pg_query($conn, "ROLLBACK");

        echo "<script>
            alert('Semua field harus diisi!');
            window.history.back();
        </script>";
    }
} else {
    echo "<script>
        alert('Akses tidak diizinkan!');
        window.location.href = '../metadata.php';
    </script>";
}
?>
