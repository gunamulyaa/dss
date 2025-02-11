<?php
$result = pg_query($conn, "SELECT * FROM siswa");
?>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h3>Tabel Siswa</h3>
    <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#crudModal">Tambah Data</button>
</div>


<table class="table table-bordered">
    <thead class="table-dark">
        <tr>
            <th>NIM</th>
            <th>Nama</th>
            <th>Alamat</th>
            <th>Jenis Kelamin</th>
            <th>Aksi</th> <!-- Tambahkan kolom Aksi -->
        </tr>
    </thead>
    <tbody>
        <?php 
        $result = pg_query($conn, "SELECT * FROM siswa ORDER BY CAST(nim AS INTEGER) ASC");
        while ($row = pg_fetch_assoc($result)) { ?>
            <tr>
            <td><?= $row['nim']; ?></td>
            <td><?= $row['nama']; ?></td>
            <td><?= $row['alamat']; ?></td>
            <td><?= $row['jenis_kelamin']; ?></td>
            <td>
                <!-- Tombol Edit -->
                <button class='btn btn-warning edit-btn btn-sm' data-bs-toggle='modal' data-bs-target='#editDataModal'
                    data-nim='<?= $row['nim']; ?>'
                    data-nama='<?= $row['nama']; ?>'
                    data-alamat='<?= $row['alamat']; ?>'
                    data-jenis_kelamin='<?= $row['jenis_kelamin']; ?>'>
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
<div class="modal fade" id="crudModal" tabindex="-1" aria-labelledby="modalTitle" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalTitle">Tambah Data</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="crudForm" method="POST" action="crud/simpansiswa.php">
          <input type="hidden" id="mode" name="mode" value="create">
          <input type="hidden" id="old_nim" name="old_nim">

          <div class="mb-3">
            <label for="nim" class="form-label">NIM</label>
            <input type="text" class="form-control" id="nim" name="nim" required>
          </div>

          <div class="mb-3">
            <label for="nama" class="form-label">Nama</label>
            <input type="text" class="form-control" id="nama" name="nama" required>
          </div>

          <div class="mb-3">
            <label for="alamat" class="form-label">Alamat</label>
            <input type="text" class="form-control" id="alamat" name="alamat" required>
          </div>

          <div class="mb-3">
            <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
            <select class="form-control" id="jenis_kelamin" name="jenis_kelamin" required>
              <option value="Laki-laki">Laki-laki</option>
              <option value="Perempuan">Perempuan</option>
            </select>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
        <button type="submit" class="btn btn-primary" form="crudForm">Simpan</button>
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