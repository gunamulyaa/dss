document.addEventListener("DOMContentLoaded", function() {
    let dropdownBtn = document.querySelector(".dropdown-btn");
    let dropdown = document.querySelector(".dropdown");

    dropdownBtn.addEventListener("click", function() {
        dropdown.classList.toggle("active");
    });
});

function openCreateModal() {
    document.getElementById('modalTitle').innerText = "Tambah Data";
    document.getElementById('mode').value = "create";
    document.getElementById('crudForm').reset();
    var modal = new bootstrap.Modal(document.getElementById('crudModal'));
    modal.show();
}


