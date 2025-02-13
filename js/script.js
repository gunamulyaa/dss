document.addEventListener("DOMContentLoaded", function() {
    let dropdownBtn = document.querySelector(".dropdown-btn");
    let dropdown = document.querySelector(".dropdown");

    dropdownBtn.addEventListener("click", function() {
        dropdown.classList.toggle("active");
    });
});

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

