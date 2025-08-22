<?php 
include "koneksi.php";

// Fungsi untuk mengecek apakah siswa sudah absen hari ini
function sudahAbsen($nis, $conn) {
    $today = date('Y-m-d');
    $query = "SELECT * FROM absensi WHERE nis = '$nis' AND tanggal = '$today'";
    $result = mysqli_query($conn, $query);
    return mysqli_num_rows($result) > 0;
}

// Fungsi untuk mendapatkan data siswa
function getSiswa($nis, $conn) {
    $query = "SELECT * FROM data_siswa WHERE nis = '$nis'";
    $result = mysqli_query($conn, $query);
    return mysqli_fetch_assoc($result);
}

// Fungsi untuk mencatat absensi
function catatAbsensi($nis, $conn) {
    $ip_address = $_SERVER['REMOTE_ADDR'];
    $query = "INSERT INTO absensi (nis, tanggal, waktu, ip_address) VALUES (?, NOW(), NOW(), ?)";
    $stmt = mysqli_prepare($conn, $query);
    
    if (!$stmt) {
        error_log("Prepare failed: " . mysqli_error($conn));
        return false;
    }
    
    mysqli_stmt_bind_param($stmt, "ss", $nis, $ip_address);
    $result = mysqli_stmt_execute($stmt);
    
    if (!$result) {
        error_log("Execute failed: " . mysqli_stmt_error($stmt));
    }
    mysqli_stmt_close($stmt);
    return $result;
}

// Fungsi untuk mendapatkan riwayat absensi terbaru
function getRiwayatAbsensi($conn, $limit = 10) {
    $query = "SELECT a.*, s.nama, s.kelas, s.foto 
              FROM absensi a 
              JOIN data_siswa s ON a.nis = s.nis 
              ORDER BY a.tanggal DESC, a.waktu DESC 
              LIMIT $limit";
              
    $result = mysqli_query($conn, $query);
    
    if (!$result) {
        die("Query error: " . mysqli_error($conn));
    }
    
    $riwayat = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $riwayat[] = $row;
    }
    return $riwayat;
}

// Proses absensi jika ada input NIS
$pesan = '';
$nama_siswa = '';
$kelas_siswa = '';
$show_info = false;

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['nis'])) {
    $nis = trim($_POST['nis']);
    
    if (!empty($nis)) {
        $siswa = getSiswa($nis, $conn);
        
        if ($siswa) {
            if (!sudahAbsen($nis, $conn)) {
                if (catatAbsensi($nis, $conn)) {
                    $pesan = 'Absensi berhasil dicatat';
                    $nama_siswa = $siswa['nama'];
                    $kelas_siswa = $siswa['kelas'];
                    $show_info = true;
                } else {
                    $pesan = 'Gagal mencatat absensi';
                }
            } else {
                $pesan = 'Anda sudah absen hari ini';
                $nama_siswa = $siswa['nama'];
                $kelas_siswa = $siswa['kelas'];
                $show_info = true;
            }
        } else {
            $pesan = 'NIS tidak ditemukan';
        }
    } else {
        $pesan = 'Silakan masukkan NIS';
    }
}

// Ambil riwayat absensi terbaru
$riwayat_absen = getRiwayatAbsensi($conn, 10);
