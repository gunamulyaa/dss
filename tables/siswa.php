<?php
$result = pg_query($conn, "SELECT * FROM prediksi");
?>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h3>Tabel Siswa</h3>
    <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalTambahData">Tambah Data</button>
</div>


<table class="table table-bordered">
    <thead class="table-dark">
        <tr>
            <th>ID</th>
            <th>Nama Prediksi</th>
            <th>Metode</th>
            <th>Aksi</th> <!-- Tambahkan kolom Aksi -->
        </tr>
    </thead>
    <tbody>
        <?php 
        $result = pg_query($conn, "SELECT * FROM prediksi ORDER BY CAST(id AS INTEGER) ASC");
        while ($row = pg_fetch_assoc($result)) { ?>
            <tr>
            <td><?= $row['id']; ?></td>
            <td><?= $row['nama_prediksi']; ?></td>
            <td><?= $row['metode']; ?></td>
            <td>
                <!-- Tombol Edit -->
                <button class='btn btn-warning edit-btn btn-sm' data-bs-toggle='modal' data-bs-target='#editDataModal'
                    data-nim='<?= $row['id']; ?>'
                    data-nama='<?= $row['nama_prediksi']; ?>'
                    data-alamat='<?= $row['metode']; ?>'>
                Edit
                </button>
                    
                    <!-- Tombol Hapus -->
                    <a href="crud/hapussiswa.php?nim=<?= $row['nim']; ?>" class="btn btn-danger btn-sm"
                       onclick="return confirm('Yakin ingin menghapus?')">Hapus</a>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>

<!-- Modal Tambah Bootstrap -->
<div class="modal fade" id="modalTambahData" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalLabel">Tambah Data</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="formTambahData">
          <div class="mb-3">
            <label for="nim" class="form-label">NIM</label>
            <input type="text" class="form-control" id="nim">
          </div>
          <div class="mb-3">
            <label for="nama" class="form-label">Nama</label>
            <input type="text" class="form-control" id="nama">
          </div>
          <div class="mb-3">
            <label for="alamat" class="form-label">Alamat</label>
            <input type="text" class="form-control" id="alamat">
          </div>

          <!-- Dinamis: Jumlah Kriteria dan Alternatif -->
          <div class="mb-3">
            <label for="jumlahKriteria" class="form-label">Jumlah Kriteria</label>
            <div class="input-group">
              <button class="btn btn-outline-secondary" type="button" onclick="ubahJumlah('kriteria', -1)">-</button>
              <input type="number" class="form-control text-center" id="jumlahKriteria" value="1" readonly>
              <button class="btn btn-outline-secondary" type="button" onclick="ubahJumlah('kriteria', 1)">+</button>
            </div>
          </div>
          <div id="kriteriaContainer"></div>
          
          <div class="mb-3">
            <label for="jumlahAlternatif" class="form-label">Jumlah Alternatif</label>
            <div class="input-group">
              <button class="btn btn-outline-secondary" type="button" onclick="ubahJumlah('alternatif', -1)">-</button>
              <input type="number" class="form-control text-center" id="jumlahAlternatif" value="1" readonly>
              <button class="btn btn-outline-secondary" type="button" onclick="ubahJumlah('alternatif', 1)">+</button>
            </div>
          </div>
          <div id="alternatifContainer"></div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
        <button type="submit" class="btn btn-primary">Simpan</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal Edit Data -->
<div class="modal fade" id="editDataModal" tabindex="-1" aria-labelledby="editDataModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editDataModalLabel">Edit Data</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editForm" method="POST" action="crud/editsiswa.php">
                    <input type="hidden" id="editNim" name="nim">
                    
                    <div class="mb-3">
                        <label for="editNama" class="form-label">Nama</label>
                        <input type="text" class="form-control" id="editNama" name="nama" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="editAlamat" class="form-label">Alamat</label>
                        <input type="text" class="form-control" id="editAlamat" name="alamat" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="editJenisKelamin" class="form-label">Jenis Kelamin</label>
                        <select class="form-control" id="editJenisKelamin" name="jenis_kelamin">
                            <option value="Laki-laki">Laki-laki</option>
                            <option value="Perempuan">Perempuan</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
  function ubahJumlah(type, delta) {
    const input = document.getElementById(`jumlah${type.charAt(0).toUpperCase() + type.slice(1)}`);
    let jumlah = parseInt(input.value) + delta;
    if (jumlah < 1) jumlah = 1;
    input.value = jumlah;
    perbaruiForm(type, jumlah);
  }

  function perbaruiForm(type, jumlah) {
    const container = document.getElementById(`${type}Container`);
    container.innerHTML = '';
    for (let i = 1; i <= jumlah; i++) {
      let html = `<div class="mb-3">
                    <label class="form-label">Nama ${type.charAt(0).toUpperCase() + type.slice(1)} ${i}</label>
                    <input type="text" class="form-control" name="${type}${i}">
                  </div>`;
      if (type === 'kriteria') {
        html += `<div class="mb-3">
                    <label class="form-label">Bobot Kriteria ${i}</label>
                    <input type="number" class="form-control" name="bobot${i}" step="0.01">
                  </div>`;
      }
      container.innerHTML += html;
    }
  }

document.addEventListener('DOMContentLoaded', function () {
    var editModal = document.getElementById('editDataModal');
    editModal.addEventListener('show.bs.modal', function (event) {
        var button = event.relatedTarget;
        var nim = button.getAttribute('data-nim');
        var nama = button.getAttribute('data-nama');
        var alamat = button.getAttribute('data-alamat');
        var jenisKelamin = button.getAttribute('data-jenis_kelamin');

        var modalNim = editModal.querySelector('#editNim');
        var modalNama = editModal.querySelector('#editNama');
        var modalAlamat = editModal.querySelector('#editAlamat');
        var modalJenisKelamin = editModal.querySelector('#editJenisKelamin');

        modalNim.value = nim;
        modalNama.value = nama;
        modalAlamat.value = alamat;
        modalJenisKelamin.value = jenisKelamin;
    });
});
</script>






<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="js/script.js"></script>