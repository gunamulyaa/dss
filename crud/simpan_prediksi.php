<?php
include '../config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama_prediksi = $_POST['nama'];
    $metode = $_POST['metode'];

    // Simpan ke tabel prediksi
    $query_prediksi = "INSERT INTO prediksi (nama, metode) VALUES ($1, $2) RETURNING id";
    $result_prediksi = pg_query_params($conn, $query_prediksi, [$nama_prediksi, $metode]);

    if (!$result_prediksi) {
        echo json_encode(['status' => 'error', 'message' => pg_last_error($conn)]);
        exit;
    }

    $row = pg_fetch_assoc($result_prediksi);
    $id_prediksi = $row['id'];

    // Simpan kriteria
    if (isset($_POST['kriteria']) && isset($_POST['bobot']) && isset($_POST['tipe'])) {
        $kriteria = $_POST['kriteria'];
        $bobot = $_POST['bobot'];
        $tipe = $_POST['tipe'];

        $id_kriteria_list = [];

        for ($i = 0; $i < count($kriteria); $i++) {
            $query_kriteria = "INSERT INTO kriteria (id_prediksi, nama, bobot, tipe) VALUES ($1, $2, $3, $4) RETURNING id";
            $result_kriteria = pg_query_params($conn, $query_kriteria, [$id_prediksi, $kriteria[$i], $bobot[$i], $tipe[$i]]);
            
            if ($result_kriteria) {
                $row_kriteria = pg_fetch_assoc($result_kriteria);
                $id_kriteria_list[] = $row_kriteria['id'];
            } else {
                echo json_encode(['status' => 'error', 'message' => pg_last_error($conn)]);
                exit;
            }
        }
    }

    // Simpan alternatif secara terpisah
    if (isset($_POST['alternatif'])) {
        $alternatif = $_POST['alternatif'];
        $id_alternatif_list = [];

        foreach ($alternatif as $nama_alternatif) {
            $query_alternatif = "INSERT INTO alternatif (id_prediksi, nama) VALUES ($1, $2) RETURNING id";
            $result_alternatif = pg_query_params($conn, $query_alternatif, [$id_prediksi, $nama_alternatif]);

            if ($result_alternatif) {
                $row_alternatif = pg_fetch_assoc($result_alternatif);
                $id_alternatif_list[] = ['id' => $row_alternatif['id'], 'nama' => $nama_alternatif];
            } else {
                echo json_encode(['status' => 'error', 'message' => pg_last_error($conn)]);
                exit;
            }
        }

        echo json_encode(['status' => 'success', 'alternatif' => $id_alternatif_list]);
        exit;
    }

    // Simpan nilai alternatif secara terpisah
    if (isset($_POST['nilai_alternatif']) && isset($_POST['id_alternatif'])) {
        $nilai_alternatif = $_POST['nilai_alternatif'];
        $id_alternatif = $_POST['id_alternatif'];

        foreach ($nilai_alternatif as $id_kriteria => $nilai) {
            $query_nilai_alternatif = "INSERT INTO nilai_alternatif (id_prediksi, id_alternatif, id_kriteria, nilai) VALUES ($1, $2, $3, $4)";
            $result_nilai_alternatif = pg_query_params($conn, $query_nilai_alternatif, [$id_prediksi, $id_alternatif, $id_kriteria, $nilai]);

            if (!$result_nilai_alternatif) {
                echo json_encode(['status' => 'error', 'message' => pg_last_error($conn)]);
                exit;
            }
        }

        echo json_encode(['status' => 'success']);
        exit;
    }

    header("Location: ../index.php");
    exit();
}
?>
