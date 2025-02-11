<?php
$conn = pg_connect("host=localhost dbname=dss user=postgres password=010302");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nim = $_POST['nim'];
    $nama = $_POST['nama'];
    $alamat = $_POST['alamat'];
    $jenis_kelamin = $_POST['jenis_kelamin'];

    $query = "UPDATE siswa SET 
                nama = '$nama', 
                alamat = '$alamat', 
                jenis_kelamin = '$jenis_kelamin' 
              WHERE nim = '$nim'";

    $result = pg_query($conn, $query);

    if ($result) {
        echo json_encode(["status" => "success"]);
        header("Location: ../metadata.php");
    } else {
        echo json_encode(["status" => "error", "message" => pg_last_error($conn)]);
    }
}
?>
