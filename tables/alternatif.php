<?php
// Query untuk mendapatkan data
$query = "SELECT 
            a.nama AS nama_alternatif, 
            k.nama AS nama_kriteria, 
            na.nilai
          FROM alternatif a
          JOIN nilai_alternatif na ON a.id = na.alternatif_id
          JOIN kriteria k ON na.kriteria_id = k.id
          ORDER BY a.nama, k.nama"; 

$result = pg_query($conn, $query);

// Format ulang hasil query menjadi array
$data = [];
$kriteria = [];

while ($row = pg_fetch_assoc($result)) {
    $data[$row['nama_alternatif']][$row['nama_kriteria']] = $row['nilai'];
    $kriteria[$row['nama_kriteria']] = true; // Simpan daftar kriteria unik
}
?>

<table class="table table-bordered table-striped">
    <thead class="table-dark">
        <tr>
             <th>Nama Alternatif</th>
            <?php foreach (array_keys($kriteria) as $nama_kriteria) { ?>
                <th><?= $nama_kriteria; ?></th>
            <?php } ?>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($data as $nama_alternatif => $nilai_kriteria) { ?>
            <tr>
                <td><?= $nama_alternatif; ?></td>
                <?php foreach ($kriteria as $nama_kriteria => $value) { ?>
                    <td><?= isset($nilai_kriteria[$nama_kriteria]) ? $nilai_kriteria[$nama_kriteria] : '-'; ?></td>
                <?php } ?>
            </tr>
        <?php } ?>
    </tbody>
</table>