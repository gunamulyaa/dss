<?php
$conn = pg_connect("host=autorack.proxy.rlwy.net dbname=railway user=postgres password=OUCHgADVOdfsEdrWFeUZFFjbcbgFfjIA");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $mode = $_POST['mode']; // 'create' atau 'edit'
    $nama_prediksi = $_POST['nama_prediksi'];
    $metode = $_POST['metode']; // SAW, WP, atau TOPSIS

    if ($mode == 'create') {
        // Insert ke tabel `prediksi`
        $query = "INSERT INTO prediksi (nama_prediksi, metode) VALUES ('$nama_prediksi', '$metode') RETURNING id";
        $result = pg_query($conn, $query);
        $row = pg_fetch_assoc($result);
        $prediksi_id = $row['id']; // Ambil ID terbaru

        // Insert ke tabel `kriteria`
        foreach ($_POST['kriteria'] as $kriteria) {
            $nama_kriteria = $kriteria['nama'];
            $tipe = $kriteria['tipe'];
            $bobot = $kriteria['bobot'];
            $query = "INSERT INTO kriteria (prediksi_id, nama, tipe, bobot) VALUES ('$prediksi_id', '$nama_kriteria', '$tipe', '$bobot') RETURNING id";
            $result = pg_query($conn, $query);
            $row = pg_fetch_assoc($result);
            $kriteria_id = $row['id'];

            // Insert ke tabel `alternatif`
            foreach ($_POST['alternatif'] as $alternatif) {
                $nama_alternatif = $alternatif['nama'];
                $query = "INSERT INTO alternatif (prediksi_id, nama) VALUES ('$prediksi_id', '$nama_alternatif') RETURNING id";
                $result = pg_query($conn, $query);
                $row = pg_fetch_assoc($result);
                $alternatif_id = $row['id'];

                // Insert ke tabel `nilai_alternatif`
                $nilai = $alternatif['nilai'][$nama_kriteria]; // Ambil nilai berdasarkan kriteria
                $query = "INSERT INTO nilai_alternatif (alternatif_id, kriteria_id, nilai) VALUES ('$alternatif_id', '$kriteria_id', '$nilai')";
                pg_query($conn, $query);
            }
        }
    } elseif ($mode == 'edit') {
        $prediksi_id = $_POST['prediksi_id'];

        // Update `prediksi`
        $query = "UPDATE prediksi SET nama_prediksi='$nama_prediksi', metode='$metode' WHERE id='$prediksi_id'";
        pg_query($conn, $query);

        // Update atau Insert `kriteria`
        foreach ($_POST['kriteria'] as $kriteria) {
            $kriteria_id = $kriteria['id'] ?? null;
            $nama_kriteria = $kriteria['nama'];
            $tipe = $kriteria['tipe'];
            $bobot = $kriteria['bobot'];

            if ($kriteria_id) {
                $query = "UPDATE kriteria SET nama='$nama_kriteria', tipe='$tipe', bobot='$bobot' WHERE id='$kriteria_id'";
            } else {
                $query = "INSERT INTO kriteria (prediksi_id, nama, tipe, bobot) VALUES ('$prediksi_id', '$nama_kriteria', '$tipe', '$bobot') RETURNING id";
                $result = pg_query($conn, $query);
                $row = pg_fetch_assoc($result);
                $kriteria_id = $row['id'];
            }
            pg_query($conn, $query);

            // Update atau Insert `nilai_alternatif`
            foreach ($_POST['alternatif'] as $alternatif) {
                $alternatif_id = $alternatif['id'] ?? null;
                $nama_alternatif = $alternatif['nama'];

                if ($alternatif_id) {
                    $query = "UPDATE alternatif SET nama='$nama_alternatif' WHERE id='$alternatif_id'";
                } else {
                    $query = "INSERT INTO alternatif (prediksi_id, nama) VALUES ('$prediksi_id', '$nama_alternatif') RETURNING id";
                    $result = pg_query($conn, $query);
                    $row = pg_fetch_assoc($result);
                    $alternatif_id = $row['id'];
                }
                pg_query($conn, $query);

                $nilai = $alternatif['nilai'][$nama_kriteria]; 
                $query = "UPDATE nilai_alternatif SET nilai='$nilai' WHERE alternatif_id='$alternatif_id' AND kriteria_id='$kriteria_id'";
                pg_query($conn, $query);
            }
        }
    }

    header("Location: ../metadata.php");
}
?>
