<?php
$conn = pg_connect("host=autorack.proxy.rlwy.net dbname=railway user=postgres password=OUCHgADVOdfsEdrWFeUZFFjbcbgFfjIA"); // Koneksi ke database PostgreSQL


if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    $id = $_GET['id'];

    // Mulai transaksi agar penghapusan bersifat atomik
    pg_query($conn, "BEGIN");

    try {
        // Hapus nilai alternatif terkait dengan prediksi
        $query1 = "DELETE FROM nilai_alternatif WHERE id_alternatif IN 
                   (SELECT id FROM alternatif WHERE id_prediksi = $1)";
        pg_query_params($conn, $query1, array($id));

        // Hapus alternatif terkait dengan prediksi
        $query2 = "DELETE FROM alternatif WHERE id_prediksi = $1";
        pg_query_params($conn, $query2, array($id));

        // Hapus kriteria terkait dengan prediksi
        $query3 = "DELETE FROM kriteria WHERE id_prediksi = $1";
        pg_query_params($conn, $query3, array($id));

        // Hapus prediksi utama
        $query4 = "DELETE FROM prediksi WHERE id = $1";
        pg_query_params($conn, $query4, array($id));

        // Commit transaksi jika semua berhasil
        pg_query($conn, "COMMIT");

        header("Location: ../index.php?message=success_delete");
        exit();
    } catch (Exception $e) {
        // Rollback jika ada kesalahan
        pg_query($conn, "ROLLBACK");

        header("Location: ../index.php?message=error_delete");
        exit();
    }
} else {
    header("Location: ../index.php?message=invalid_access");
    exit();
}
?>
