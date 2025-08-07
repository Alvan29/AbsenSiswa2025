<?php
include 'koneksi.php';

function generateExcelReport($conn, $bulan, $kelas) {
    // Validasi parameter
    if (!is_numeric($bulan) || $bulan < 1 || $bulan > 12) {
        die("Bulan harus antara 1-12");
    }
    
    if (empty($kelas)) {
        die("Kelas tidak boleh kosong");
    }

    // 1. Ambil semua tanggal unik di bulan tersebut
    $query_tanggal = "SELECT DISTINCT DATE(tanggal) as tgl 
                     FROM absensi a 
                     JOIN data_siswa s ON a.nis = s.nis
                     WHERE MONTH(tanggal) = ? 
                     AND s.kelas = ?
                     ORDER BY tgl";
    
    $stmt_tanggal = mysqli_prepare($conn, $query_tanggal);
    mysqli_stmt_bind_param($stmt_tanggal, "ss", $bulan, $kelas);
    mysqli_stmt_execute($stmt_tanggal);
    $result_tanggal = mysqli_stmt_get_result($stmt_tanggal);
    
    $tanggal_headers = array();
    while ($row = mysqli_fetch_assoc($result_tanggal)) {
        $tanggal_headers[] = $row['tgl'];
    }

    // 2. Ambil data siswa
    $query_siswa = "SELECT s.nis, s.nama 
                   FROM data_siswa s
                   WHERE s.kelas = ?
                   ORDER BY s.nama";
                   
    $stmt_siswa = mysqli_prepare($conn, $query_siswa);
    mysqli_stmt_bind_param($stmt_siswa, "s", $kelas);
    mysqli_stmt_execute($stmt_siswa);
    $result_siswa = mysqli_stmt_get_result($stmt_siswa);

    // Header Excel
    header("Content-Type: application/vnd.ms-excel");
    header("Content-Disposition: attachment; filename=laporan_absensi_".date('Y-m-d').".xls");
    header("Pragma: no-cache");
    header("Expires: 0");

    // Buat template Excel
    echo "<table border='1'>";
    
    // Header tabel
    echo "<tr>";
    echo "<th>No</th>";
    echo "<th>NIS</th>";
    echo "<th>Nama</th>";
    foreach ($tanggal_headers as $tgl) {
        echo "<th>".date('d/m', strtotime($tgl))."</th>";
        echo "<th>IP Address</th>"; // Kolom tambahan untuk IP
    }
    echo "<th>Total Hadir</th>";
    echo "</tr>";

    // Data siswa
    $no = 1;
    while ($siswa = mysqli_fetch_assoc($result_siswa)) {
        echo "<tr>";
        echo "<td>".$no++."</td>";
        echo "<td>".$siswa['nis']."</td>";
        echo "<td>".$siswa['nama']."</td>";
        
        $total_hadir = 0;
        
        foreach ($tanggal_headers as $tgl) {
            // Cek apakah siswa hadir di tanggal tersebut
            $query_absen = "SELECT ip_address FROM absensi 
                           WHERE nis = ? 
                           AND DATE(tanggal) = ?";
            
            $stmt_absen = mysqli_prepare($conn, $query_absen);
            mysqli_stmt_bind_param($stmt_absen, "ss", $siswa['nis'], $tgl);
            mysqli_stmt_execute($stmt_absen);
            mysqli_stmt_store_result($stmt_absen);
            
            $hadir = '';
            $ip_address = '';
            
            if (mysqli_stmt_num_rows($stmt_absen) > 0) {
                mysqli_stmt_bind_result($stmt_absen, $ip);
                mysqli_stmt_fetch($stmt_absen);
                $hadir = '&#x2713';
                $ip_address = $ip;
                $total_hadir++;
            }
            
            echo "<td style='text-align:center'>".$hadir."</td>";
            echo "<td style='text-align:center'>".$ip_address."</td>";
            mysqli_stmt_close($stmt_absen);
        }
        
        echo "<td style='text-align:center'>".$total_hadir."</td>";
        echo "</tr>";
    }
    
    echo "</table>";
    mysqli_stmt_close($stmt_siswa);
    mysqli_stmt_close($stmt_tanggal);
    exit;
}

// Proses request
if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['bulan']) && isset($_GET['kelas'])) {
    $bulan = $_GET['bulan'];
    $kelas = $_GET['kelas'];
    generateExcelReport($conn, $bulan, $kelas);
} else {
    header("Location: laporan.php");
    exit;
}
?>