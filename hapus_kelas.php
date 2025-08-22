<?php
include "koneksi.php";

if (isset($_GET['id'])) {
    $id_kelas = $_GET['id'];

    // Cek apakah ada siswa yang masih menggunakan kelas ini
    $cekSiswa = mysqli_query($conn, "SELECT COUNT(*) as total FROM data_siswa WHERE id_kelas = '$id_kelas'");
    $data = mysqli_fetch_assoc($cekSiswa);

    if ($data['total'] > 0) {
        // Jika masih ada siswa
        echo "<script>
                alert('Kelas tidak dapat dihapus karena masih ada siswa yang terdaftar.');
                window.location.href='kelas_jurusan.php';
              </script>";
    } else {
        // Jika tidak ada siswa, hapus kelas
        $hapus = mysqli_query($conn, "DELETE FROM kelas WHERE id='$id_kelas'");
        if ($hapus) {
            echo "<script>
                    alert('Kelas berhasil dihapus.');
                    window.location.href='kelas_jurusan.php';
                  </script>";
        } else {
            echo "<script>
                    alert('Terjadi kesalahan saat menghapus kelas.');
                    window.location.href='kelas_jurusan.php';
                  </script>";
        }
    }
} else {
    // Jika tidak ada ID yang dikirim
    echo "<script>
            alert('ID kelas tidak ditemukan.');
            window.location.href='kelas_jurusan.php';
          </script>";
}
?>
