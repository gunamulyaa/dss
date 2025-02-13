<?php
// Query untuk mendapatkan data
$query = "SELECT 
            p.id AS id_prediksi,
            p.nama_prediksi,
            p.metode,
            a.nama AS nama_alternatif,
            h.skor AS skor
          FROM prediksi p
          JOIN alternatif a ON p.id = a.prediksi_id
          JOIN hasil h ON a.id = h.alternatif_id AND p.id = h.prediksi_id
          ORDER BY p.id, a.nama";

$result = pg_query($conn,$query);
?>

<table class="table table-bordered table-striped">
    <thead class="table-dark">
        <tr>
            <th>ID Prediksi</th>
            <th>Nama Prediksi</th>
            <th>Metode</th>
            <th>Alternatif Terbaik</th>
            <th>Skor</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($row = pg_fetch_assoc($result)) { ?>
            <tr>
                <td><?= $row['id_prediksi']; ?></td>
                <td><?= $row['nama_prediksi']; ?></td>
                <td><?= $row['metode']; ?></td>
                <td><?= $row['nama_alternatif']; ?></td>
                <td><?= $row['skor']; ?></td>
            </tr>
        <?php } ?>
    </tbody>
</table>
