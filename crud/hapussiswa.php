<?php
$conn = pg_connect("host=localhost dbname=dss user=postgres password=010302");

if (!$conn) {
    die(json_encode(["status" => "error", "message" => "Koneksi gagal: " . pg_last_error()]));
}

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $nim = $_GET['nim'] ?? '';

    if (empty($nim)) {
        die(json_encode(["status" => "error", "message" => "NIM tidak boleh kosong"]));
    }

    // Cek apakah data ada sebelum menghapus
    $check = pg_query_params($conn, "SELECT * FROM siswa WHERE nim = $1", [$nim]);
    if (pg_num_rows($check) == 0) {
        die(json_encode(["status" => "error", "message" => "Data tidak ditemukan"]));
    }

    // Hapus data
    $query = "DELETE FROM siswa WHERE nim = $1";
    $result = pg_query_params($conn, $query, [$nim]);

    if ($result) {
        echo json_encode(["status" => "success"]);
        header("Location: ../metadata.php");
        exit;
    } else {
        echo json_encode(["status" => "error", "message" => pg_last_error($conn)]);
    }
}
?>
