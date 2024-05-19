// JavaScript untuk menampilkan dan menyembunyikan loading
// JavaScript untuk menampilkan dan menyembunyikan loading
document.addEventListener('DOMContentLoaded', function() {
    var loading = document.querySelector('.loading');
    loading.classList.add('hidden'); // Tambahkan kelas 'hidden' untuk menyembunyikan loading



    // Menyembunyikan loading setelah beberapa waktu (misalnya, 2 detik)
    setTimeout(function() {
        loading.style.display = 'none';
    }, 5000); // Ubah angka 2000 menjadi waktu yang diinginkan (dalam milidetik)
});
