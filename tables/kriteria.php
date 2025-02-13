<?php
$result = pg_query($conn, "SELECT * FROM kriteria");
?>

<table class="table table-bordered table-striped">
    <thead class="table-dark">
        <tr>
            <th>ID</th>
            <th>Nama Kriteria</th>
            <th>Tipe</th>
            <th>Bobot</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($row = pg_fetch_assoc($result)) { ?>
            <tr>
                <td><?= $row['prediksi_id']; ?></td>
                <td><?= $row['nama']; ?></td>
                <td><?= $row['tipe']; ?></td>
                <td><?= $row['bobot']; ?></td>
            </tr>
        <?php } ?>
    </tbody>
</table>
