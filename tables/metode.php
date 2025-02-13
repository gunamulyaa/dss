<?php
    $result = pg_query($conn, "SELECT * FROM prediksi");
?>

<table class="table table-bordered table-striped">
    <thead class="table-dark">
        <tr>
            <th>ID</th>
            <th>Nama Prediksi</th>
            <th>Metode</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($row = pg_fetch_assoc($result)) { ?>
            <tr>
                <td><?= $row['id']; ?></td>
                <td><?= $row['nama_prediksi']; ?></td>
                <td><?= $row['metode']; ?></td>
            </tr>
        <?php } ?>
    </tbody>
</table>
