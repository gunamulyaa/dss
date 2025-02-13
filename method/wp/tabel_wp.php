<?php
include 'config.php';
// Koneksi ke database

// Ambil prediksi dengan metode SAW
$query = "SELECT * FROM prediksi WHERE metode = 'WP'";
$result = pg_query($conn, $query);
?>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>


<div class="d-flex justify-content-between align-items-center mb-3">
    <h3>Daftar Prediksi Metode SAW</h3>
</div>

<table class="table table-bordered">
    <thead class="table-dark">
        <tr>
            <th>ID</th>
            <th>Nama Prediksi</th>
            <th>Metode</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($row = pg_fetch_assoc($result)) { ?>
            <tr>
                <td><?= $row['id']; ?></td>
                <td><?= $row['nama_prediksi']; ?></td>
                <td><?= $row['metode']; ?></td>
                <td>
                <button class='btn btn-warning edit-btn btn-sm' data-bs-toggle='modal' data-bs-target='#modalDetail'
                        data-id='<?= $row['id']; ?>'
                        data-nama='<?= $row['nama_prediksi']; ?>'
                        data-metode='<?= $row['metode']; ?>'>
                        Details
                    </button>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>

<!-- Modal Detail -->
<div class="modal fade" id="modalDetail" tabindex="-1" aria-labelledby="modalDetailLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalDetailLabel">Detail Prediksi</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <h4>Informasi Prediksi</h4>
        <p><strong>Nama:</strong> <span id="detailNama"></span></p>
        <p><strong>Metode:</strong> <span id="detailMetode"></span></p>

        <h4>Kriteria</h4>
        <table class="table table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>Nama Kriteria</th>
                    <th>Bobot</th>
                    <th>Tipe</th>
                </tr>
            </thead>
            <tbody id="detailKriteria"></tbody>
        </table>

        <h4>Alternatif</h4>
        <table class="table table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>Nama Alternatif</th>
                </tr>
            </thead>
            <tbody id="detailAlternatif"></tbody>
        </table>

        <h4>Nilai Alternatif</h4>
        <table class="table table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>Alternatif</th>
                    <th>Kriteria</th>
                    <th>Nilai</th>
                </tr>
            </thead>
            <tbody id="detailNilai"></tbody>
        </table>
        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Tutup</button>
        <button type="button" class="btn btn-success" id="btnHitung">Hitung</button>
      </div>
    </div>
  </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll(".lihat-detail").forEach(button => {
        button.addEventListener("click", function () {
            let idPrediksi = this.getAttribute("data-id");

            fetch(`get_detail_prediksi.php?id=${idPrediksi}`)
                .then(response => response.json())
                .then(data => {
                    console.log("Response Data:", data); // Debugging

                    if (!data || Object.keys(data).length === 0) {
                        alert("Data tidak ditemukan!");
                        return;
                    }

                    // Set data ke modal
                    document.getElementById("detailNama").textContent = data.prediksi?.nama_prediksi || "N/A";
                    document.getElementById("detailMetode").textContent = data.prediksi?.metode || "N/A";

                    // Isi tabel kriteria
                    let kriteriaHTML = "";
                    if (Array.isArray(data.kriteria)) {
                        kriteriaHTML = data.kriteria.map(k => `
                            <tr>
                                <td>${k.nama_kriteria}</td>
                                <td>${k.bobot}</td>
                                <td>${k.tipe}</td>
                            </tr>
                        `).join('');
                    }
                    document.getElementById("detailKriteria").innerHTML = kriteriaHTML || "<tr><td colspan='3'>Tidak ada data</td></tr>";

                    // Isi tabel alternatif
                    let alternatifHTML = "";
                    if (Array.isArray(data.alternatif)) {
                        alternatifHTML = data.alternatif.map(a => `
                            <tr><td>${a.nama}</td></tr>
                        `).join('');
                    }
                    document.getElementById("detailAlternatif").innerHTML = alternatifHTML || "<tr><td>Tidak ada data</td></tr>";

                    // Isi tabel nilai alternatif
                    let nilaiHTML = "";
                    if (Array.isArray(data.nilai)) {
                        nilaiHTML = data.nilai.map(n => `
                            <tr>
                                <td>${n.alternatif}</td>
                                <td>${n.kriteria}</td>
                                <td>${n.nilai}</td>
                            </tr>
                        `).join('');
                    }
                    document.getElementById("detailNilai").innerHTML = nilaiHTML || "<tr><td colspan='3'>Tidak ada data</td></tr>";

                    // Tampilkan modal Bootstrap
                    let modal = new bootstrap.Modal(document.getElementById("modalDetail"));
                    modal.show();
                })
                .catch(error => console.error("Error fetching data:", error));
        });
    });
});


</script>
