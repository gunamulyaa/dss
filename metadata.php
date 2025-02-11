<?php
require 'config.php';
include 'sidebar.php';
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Metadata - DSS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="content">
        <h2>Metadata - Semua Tabel</h2>
        <hr>

        <!-- Tabel Siswa -->
        <?php include 'tables/siswa.php'; ?>

        <!-- Tabel Bobot -->
        <h3>Tabel Bobot</h3>
        <?php include 'tables/bobot.php'; ?>

        <!-- Tabel Hasil -->
        <h3>Tabel Hasil</h3>
        <?php include 'tables/hasil.php'; ?>

        <!-- Tabel Kriteria -->
        <h3>Tabel Kriteria</h3>
        <?php include 'tables/kriteria.php'; ?>

        <!-- Tabel Metode -->
        <h3>Tabel Metode</h3>
        <?php include 'tables/metode.php'; ?>

        <!-- Tabel Penilaian -->
        <h3>Tabel Penilaian</h3>
        <?php include 'tables/penilaian.php'; ?>


    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
            document.addEventListener("DOMContentLoaded", function () {
            let dropdowns = document.querySelectorAll('.dropdown-toggle');
            dropdowns.forEach(dropdown => {
                dropdown.addEventListener('click', function () {
                    let menu = this.nextElementSibling;
                    menu.classList.toggle('show');
                    });
                });
            });
    </script>
</body>
</html>
