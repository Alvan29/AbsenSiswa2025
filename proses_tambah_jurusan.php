<?php
// Cek apakah form disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama_jurusan = $_POST["nama_jurusan"];

    // Validasi dasar
    if (!empty($nama_jurusan)) {
        // TODO: Tambahkan koneksi database dan query insert
        // Contoh:
        // $conn = new mysqli(...);
        // $stmt = $conn->prepare("INSERT INTO jurusan (nama_jurusan) VALUES (?)");
        // $stmt->bind_param("s", $nama_jurusan);
        // $stmt->execute();

        // Untuk saat ini dummy
        echo "Jurusan '$nama_jurusan' berhasil ditambahkan. (Simulasi)<br>";
    } else {
        echo "Nama jurusan tidak boleh kosong.<br>";
    }
}

// Redirect kembali ke halaman kelas dan jurusan
header("Location: kelas_jurusan.php");
exit;
?>
