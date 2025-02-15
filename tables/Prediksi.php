<?php
include 'config.php'; // Pastikan koneksi sudah benar

$result = pg_query($conn, "SELECT * FROM prediksi");
?>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h3>Tabel Prediksi</h3>
    <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalTambahData">Tambah Data</button>
</div>

<table class="table table-bordered">
    <thead class="table-dark">
        <tr>
            <th>ID</th>
            <th>Nama Prediksi</th>
            <th>Metode</th>
            <th>Hitung</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($row = pg_fetch_assoc($result)) { ?>
            <tr>
                <td><?= $row['id']; ?></td>
                <td><?= $row['nama']; ?></td>
                <td><?= $row['metode']; ?></td>
                <td><a href="crud/hitung_prediksi.php?id=<?= $row['id']; ?>" class="btn btn-primary btn-sm">Hitung</a>
                </td>
                <td>
                    <button class='btn btn-warning edit-btn btn-sm' data-bs-toggle='modal' data-bs-target='#modalEditData'
                        data-id='<?= $row['id']; ?>'
                        data-nama='<?= $row['nama']; ?>'
                        data-metode='<?= $row['metode']; ?>'>
                        Edit
                    </button>
                    <a href="crud/hapus_prediksi.php?id=<?= $row['id']; ?>" class="btn btn-danger btn-sm"
                        onclick="return confirm('Yakin ingin menghapus?')">Hapus</a>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>

<!-- Modal Tambah Data -->
<div class="modal fade" id="modalTambahData" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Tambah Data</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="formTambahData" method="POST" action="crud/simpan_prediksi.php">
          <div class="mb-3">
            <label class="form-label">Nama Prediksi</label>
            <input type="text" class="form-control" name="nama" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Metode</label>
            <select class="form-select" name="metode" required>
              <option value="SAW">SAW</option>
              <option value="WP">WP</option>
              <option value="TOPSIS">TOPSIS</option>
            </select>
          </div>
          
          <h5>Kriteria</h5>
          <div id="kriteriaContainer"></div>
          <button type="button" class="btn btn-secondary btn-sm" onclick="tambahKriteria()">+ Tambah Kriteria</button>
          
          <h5 class="mt-3">Alternatif</h5>
          <div id="alternatifContainer"></div>
          <button type="button" class="btn btn-secondary btn-sm" onclick="tambahAlternatif()">+ Tambah Alternatif</button>
        
          <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
        <button type="submit" class="btn btn-primary">Simpan</button>
      </div>

        </form>
      </div>

    </div>
  </div>
</div>

<div class="modal fade" id="modalEditData" tabindex="-1" aria-labelledby="modalEditLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Edit Data</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="formEditData" method="post" action="crud/update_prediksi.php">
          <input type="hidden" name="id" id="editId"> <!-- ID tersembunyi untuk update -->
          
          <div class="mb-3">
            <label class="form-label">Nama Prediksi</label>
            <input type="text" class="form-control" name="nama" id="editNamaPrediksi" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Metode</label>
            <select class="form-select" name="metode" id="editMetode" required>
              <option value="SAW">SAW</option>
              <option value="WP">WP</option>
              <option value="TOPSIS">TOPSIS</option>
            </select>
          </div>

          <h5>Kriteria</h5>
          <div id="editKriteriaContainer"></div>
          <button type="button" class="btn btn-secondary btn-sm" onclick="tambahKriteriaEdit()">+ Tambah Kriteria</button>

          <h5 class="mt-3">Alternatif</h5>
          <div id="editAlternatifContainer"></div>
          <button type="button" class="btn btn-secondary btn-sm" onclick="tambahAlternatifEdit()">+ Tambah Alternatif</button>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
        <button type="submit" class="btn btn-primary" form="formEditData">Simpan Perubahan</button>
      </div>
    </div>
  </div>
</div>

<script>

// Fungsi untuk menambah kriteria
function tambahKriteria() {
    let container = document.getElementById("kriteriaContainer");
    let index = container.children.length + 1;

    let html = `<div class="mb-2 kriteria-item" id="kriteria-${index}" data-index="${index}">
                    <input type="text" class="form-control mb-1" name="kriteria[]" placeholder="Nama Kriteria" required>
                    <input type="number" class="form-control mb-1" name="bobot[]" placeholder="Bobot" step="0.01" required>
                    <select class="form-select mb-1" name="tipe[]" required>
                        <option value="benefit">Benefit</option>
                        <option value="cost">Cost</option>
                    </select>
                    <button type="button" class="btn btn-danger btn-sm" onclick="hapusKriteria(${index})">Hapus</button>
                </div>`;

    container.innerHTML += html;

    // Tambahkan input nilai ke setiap alternatif yang sudah ada (di luar tombol hapus)
    document.querySelectorAll(".alternatif-item").forEach((alt) => {
        let inputGroup = document.createElement("div");
        inputGroup.className = "nilai-group"; // Beri class supaya bisa dihapus nanti

        let nilaiInput = document.createElement("input");
        nilaiInput.type = "number";
        nilaiInput.className = "form-control mb-1";
        nilaiInput.name = `nilai_alternatif[${alt.dataset.index}][]`;
        nilaiInput.placeholder = "Nilai";
        nilaiInput.step = "0.01";
        nilaiInput.required = true;

        inputGroup.appendChild(nilaiInput);
        alt.insertBefore(inputGroup, alt.lastElementChild); // Pastikan tidak masuk ke tombol hapus
    });
}

// Fungsi untuk menghapus kriteria
function hapusKriteria(index) {
    let element = document.getElementById(`kriteria-${index}`);
    if (element) {
        element.remove();
    }

    // Hapus nilai alternatif yang sesuai dengan kriteria yang dihapus
    document.querySelectorAll(".alternatif-item").forEach((alt) => {
        let nilaiGroups = alt.querySelectorAll(".nilai-group");
        if (nilaiGroups.length > 0) {
            nilaiGroups[nilaiGroups.length - 1].remove();
        }
    });
}

// Fungsi untuk menambah alternatif
function tambahAlternatif() {
    let container = document.getElementById("alternatifContainer");
    let index = container.children.length + 1;
    let jumlahKriteria = document.querySelectorAll("#kriteriaContainer > div").length;

    let html = `<div class="mb-2 alternatif-item" id="alternatif-${index}" data-index="${index}">
                    <input type="text" class="form-control mb-1" name="alternatif[]" placeholder="Nama Alternatif" required>`;

    // Tambahkan input nilai sesuai dengan jumlah kriteria
    for (let i = 0; i < jumlahKriteria; i++) {
        html += `<div class="nilai-group">
                    <input type="number" class="form-control mb-1" name="nilai_alternatif[${index}][]" placeholder="Nilai" step="0.01" required>
                 </div>`;
    }

    html += `<button type="button" class="btn btn-danger btn-sm" onclick="hapusAlternatif(${index})">Hapus</button>
            </div>`;

    container.innerHTML += html;
}

// Fungsi untuk menghapus alternatif
function hapusAlternatif(index) {
    let element = document.getElementById(`alternatif-${index}`);
    if (element) {
        element.remove();
    }
}



</script>



