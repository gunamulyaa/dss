<?php
$result = pg_query($conn, "SELECT * FROM metode");
?>

<table class="table table-bordered table-striped">
    <thead class="table-dark">
        <tr>
            <th>ID</th>
            <th>Nama</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($row = pg_fetch_assoc($result)) { ?>
            <tr>
                <td><?= $row['id']; ?></td>
                <td><?= $row['nama']; ?></td>
            </tr>
        <?php } ?>
    </tbody>
</table>
