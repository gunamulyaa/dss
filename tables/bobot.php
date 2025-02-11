<?php
$result = pg_query($conn, "SELECT * FROM bobot");
?>

<table class="table table-bordered table-striped">
    <thead class="table-dark">
        <tr>
            <th>ID</th>
            <th>Kriteria ID</th>
            <th>Nilai</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($row = pg_fetch_assoc($result)) { ?>
            <tr>
                <td><?= $row['id']; ?></td>
                <td><?= $row['kriteria_id']; ?></td>
                <td><?= $row['nilai']; ?></td>
            </tr>
        <?php } ?>
    </tbody>
</table>
