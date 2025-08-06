<?php
// Cek apakah form disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama_kelas = $_POST["nama_kelas"];

    // Validasi dasar
    if (!empty($nama_kelas)) {
        // TODO: Tambahkan koneksi database dan query insert
        // Contoh:
        // $conn = new mysqli(...);
        // $stmt = $conn->prepare("INSERT INTO kelas (nama_kelas) VALUES (?)");
        // $stmt->bind_param("s", $nama_kelas);
        // $stmt->execute();

        // Untuk saat ini dummy
        echo "Kelas '$nama_kelas' berhasil ditambahkan. (Simulasi)<br>";
    } else {
        echo "Nama kelas tidak boleh kosong.<br>";
    }
}

// Redirect kembali ke halaman kelas dan jurusan
header("Location: kelas_jurusan.php");
exit;
?>
