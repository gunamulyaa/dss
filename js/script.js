document.addEventListener("DOMContentLoaded", function () {
  let dropdownBtn = document.querySelector(".dropdown-btn");
  let dropdown = document.querySelector(".dropdown");

  dropdownBtn.addEventListener("click", function () {
      dropdown.classList.toggle("active");
  });
});

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

  // Tambahkan input nilai ke setiap alternatif yang sudah ada
  document.querySelectorAll(".alternatif-item").forEach((alt) => {
      let nilaiInput = document.createElement("input");
      nilaiInput.type = "number";
      nilaiInput.className = "form-control mb-1";
      nilaiInput.name = `nilai_alternatif[${alt.dataset.index}][]`;
      nilaiInput.placeholder = "Nilai";
      nilaiInput.step = "0.01";
      nilaiInput.required = true;
      alt.appendChild(nilaiInput);
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
      let nilaiInputs = alt.querySelectorAll("input[type='number']");
      if (nilaiInputs.length > 0) {
          nilaiInputs[nilaiInputs.length - 1].remove();
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
      html += `<input type="number" class="form-control mb-1" name="nilai_alternatif[${index}][]" placeholder="Nilai" step="0.01" required>`;
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
