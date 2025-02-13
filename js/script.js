document.addEventListener("DOMContentLoaded", function() {
    let dropdownBtn = document.querySelector(".dropdown-btn");
    let dropdown = document.querySelector(".dropdown");

    dropdownBtn.addEventListener("click", function() {
        dropdown.classList.toggle("active");
    });
});

function tambahKriteria() {
    let container = document.getElementById("kriteriaContainer");
    let index = container.children.length + 1;
    let html = `<div class="mb-2" id="kriteria-${index}">
                    <input type="text" class="form-control mb-1" name="kriteria[]" placeholder="Nama Kriteria" required>
                    <input type="number" class="form-control mb-1" name="bobot[]" placeholder="Bobot" step="0.01" required>
                    <select class="form-select mb-1" name="tipe[]" required>
                        <option value="benefit">Benefit</option>
                        <option value="cost">Cost</option>
                    </select>
                    <button type="button" class="btn btn-danger btn-sm" onclick="hapusKriteria(${index})">Hapus</button>
                </div>`;
    container.innerHTML += html;
}

function hapusKriteria(index) {
    let element = document.getElementById(`kriteria-${index}`);
    if (element) element.remove();
}

function tambahAlternatif() {
    let container = document.getElementById("alternatifContainer");
    let index = container.children.length + 1;
    let html = `<div class="mb-2" id="alternatif-${index}">
                    <input type="text" class="form-control mb-1" name="alternatif[]" placeholder="Nama Alternatif" required>
                    <input type="number" class="form-control mb-1" name="nilai[]" placeholder="Nilai" step="0.01" required>
                    <button type="button" class="btn btn-danger btn-sm" onclick="hapusAlternatif(${index})">Hapus</button>
                </div>`;
    container.innerHTML += html;
}

function hapusAlternatif(index) {
    let element = document.getElementById(`alternatif-${index}`);
    if (element) element.remove();
}

 // Event untuk menampilkan data ke dalam modal edit
 document.querySelectorAll(".edit-btn").forEach(button => {
    button.addEventListener("click", function () {
      let id = this.dataset.id;
      let nama = this.dataset.nama;
      let metode = this.dataset.metode;

      document.getElementById("editId").value = id;
      document.getElementById("editNamaPrediksi").value = nama;
      document.getElementById("editMetode").value = metode;

      // Bersihkan container sebelum ditambahkan ulang
      document.getElementById("editKriteriaContainer").innerHTML = "";
      document.getElementById("editAlternatifContainer").innerHTML = "";
    });
  });

  function tambahKriteriaEdit() {
    let container = document.getElementById("editKriteriaContainer");
    let index = container.children.length + 1;
    let html = `<div class="mb-2" id="editKriteria-${index}">
                    <input type="text" class="form-control mb-1" name="kriteria[]" placeholder="Nama Kriteria" required>
                    <input type="number" class="form-control mb-1" name="bobot[]" placeholder="Bobot" step="0.01" required>
                    <select class="form-select mb-1" name="tipe[]" required>
                        <option value="benefit">Benefit</option>
                        <option value="cost">Cost</option>
                    </select>
                    <button type="button" class="btn btn-danger btn-sm" onclick="hapusKriteriaEdit(${index})">Hapus</button>
                </div>`;
    container.innerHTML += html;
  }

  function hapusKriteriaEdit(index) {
    let element = document.getElementById(`editKriteria-${index}`);
    if (element) element.remove();
  }

  function tambahAlternatifEdit() {
    let container = document.getElementById("editAlternatifContainer");
    let index = container.children.length + 1;
    let html = `<div class="mb-2" id="editAlternatif-${index}">
                    <input type="text" class="form-control mb-1" name="alternatif[]" placeholder="Nama Alternatif" required>
                    <input type="number" class="form-control mb-1" name="nilai[]" placeholder="Nilai" step="0.01" required>
                    <button type="button" class="btn btn-danger btn-sm" onclick="hapusAlternatifEdit(${index})">Hapus</button>
                </div>`;
    container.innerHTML += html;
  }

  function hapusAlternatifEdit(index) {
    let element = document.getElementById(`editAlternatif-${index}`);
    if (element) element.remove();
  }