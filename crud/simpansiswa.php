<?php
$conn = pg_connect("host=localhost dbname=dss user=postgres password=010302");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $mode = $_POST['mode'];
    $nim = $_POST['nim'];
    $nama = $_POST['nama'];
    $alamat = $_POST['alamat'];
    $jenis_kelamin = $_POST['jenis_kelamin'];

    if ($mode == 'create') {
        $query = "INSERT INTO siswa (nim, nama, alamat, jenis_kelamin) VALUES ('$nim', '$nama', '$alamat', '$jenis_kelamin')";
    } else if ($mode == 'edit') {
        $old_nim = $_POST['old_nim'];
        $query = "UPDATE siswa SET nim='$nim', nama='$nama', alamat='$alamat', jenis_kelamin='$jenis_kelamin' WHERE nim='$old_nim'";
    }

    pg_query($conn, $query);
    header("Location: ../metadata.php");
}
?>