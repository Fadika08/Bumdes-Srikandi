// Mengatur class 'active' pada label saat input mendapatkan fokus
document.querySelectorAll('.textbox input').forEach(input => {
    input.addEventListener('focus', () => {
        if (input.previousElementSibling) {
            input.previousElementSibling.classList.add('active');
        }
    });

    input.addEventListener('blur', () => {
        if (input.value === '' && input.previousElementSibling) {
            input.previousElementSibling.classList.remove('active');
        }
    });
});

// Tombol Reset: Mengarahkan ke reset_sales.php saat diklik
document.getElementById('resetBtn').addEventListener('click', function() {
    if (confirm("Apakah Anda yakin ingin mereset data penjualan?")) {
        window.location.href = "reset_sales.php";
    }
});

// Tombol Update: Meminta user memasukkan jumlah baru, lalu mengarahkan ke update_sales.php dengan nilai tersebut
document.getElementById('updateBtn').addEventListener('click', function() {
    let newAmount = prompt("Masukkan jumlah penjualan baru:");
    if (newAmount !== null && !isNaN(newAmount) && newAmount.trim() !== '') {
        window.location.href = "update_sales.php?amount=" + encodeURIComponent(newAmount);
    }
});

// Tombol Delete: Mengarahkan ke delete_last_sale.php saat diklik
document.getElementById('deleteBtn').addEventListener('click', function() {
    if (confirm("Apakah Anda yakin ingin menghapus entri penjualan terakhir?")) {
        window.location.href = "delete_last_sale.php";
    }
});

const urlParams = new URLSearchParams(window.location.search);
if (urlParams.has('error') && urlParams.get('error') == '1') {
    alert('Username atau password salah');
}

document.addEventListener("DOMContentLoaded", function() {
    const sidebar = document.querySelector('.sidebar');
    const toggleButton = document.querySelector('.sidebar-toggle');

    toggleButton.addEventListener('click', function() {
        sidebar.classList.toggle('active');
    });
});