<?php
// koneksi.php
// JEMBATAN UNTUK BACKEND - tinggal ubah data berikut
$host = 'localhost';
$user = 'root';
$pass = '';
$db_name = 'absensi_siswa';

$conn = mysqli_connect($host, $user, $pass, $db_name);

if ($conn->connect_error) {
    die('Koneksi gagal: ' . $conn->connect_error);
}
?>