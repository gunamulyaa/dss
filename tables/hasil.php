<?php
$result = pg_query($conn, "SELECT * FROM hasil");
?>

<table class="table table-bordered table-striped">
    <thead class="table-dark">
        <tr>
            <th>ID</th>
            <th>Siswa NIM</th>
            <th>Metode ID</th>
            <th>Nilai Akhir</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($row = pg_fetch_assoc($result)) { ?>
            <tr>
                <td><?= $row['id']; ?></td>
                <td><?= $row['siswa_nim']; ?></td>
                <td><?= $row['metode_id']; ?></td>
                <td><?= $row['nilai_akhir']; ?></td>
            </tr>
        <?php } ?>
    </tbody>
</table>
