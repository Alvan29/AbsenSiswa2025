<?php
include 'koneksi.php';

// Fungsi untuk menampilkan error dan menghentikan eksekusi
function showErrorAndDie($message) {
    die('<div style="color:red;padding:10px;border:1px solid red">'.$message.'</div>');
}

function generateExcelReport($conn, $bulan, $kelas) {
    // Validasi parameter
    if (!is_numeric($bulan) || $bulan < 1 || $bulan > 12) {
        showErrorAndDie("Bulan harus antara 1-12");
    }
    
    if (empty($kelas)) {
        showErrorAndDie("Kelas tidak boleh kosong");
    }

    // 1. Ambil semua tanggal unik di bulan tersebut
    $query_tanggal = "SELECT DISTINCT DATE(tanggal) as tgl 
                     FROM absensi a 
                     JOIN data_siswa s ON a.nis = s.nis
                     WHERE MONTH(tanggal) = ? 
                     AND s.kelas = ?
                     ORDER BY tgl";
    
    $stmt_tanggal = mysqli_prepare($conn, $query_tanggal);
    if ($stmt_tanggal === false) {
        showErrorAndDie("Error preparing tanggal query: " . mysqli_error($conn));
    }
    
    if (!mysqli_stmt_bind_param($stmt_tanggal, "ss", $bulan, $kelas)) {
        showErrorAndDie("Error binding tanggal parameters: " . mysqli_stmt_error($stmt_tanggal));
    }
    
    if (!mysqli_stmt_execute($stmt_tanggal)) {
        showErrorAndDie("Error executing tanggal query: " . mysqli_stmt_error($stmt_tanggal));
    }
    
    $result_tanggal = mysqli_stmt_get_result($stmt_tanggal);
    if ($result_tanggal === false) {
        showErrorAndDie("Error getting tanggal result: " . mysqli_error($conn));
    }
    
    $tanggal_headers = array();
    while ($row = mysqli_fetch_assoc($result_tanggal)) {
        $tanggal_headers[] = $row['tgl'];
    }
    mysqli_stmt_close($stmt_tanggal);

    // 2. Ambil data siswa
    $query_siswa = "SELECT s.nis, s.nama 
                   FROM data_siswa s
                   WHERE s.kelas = ?
                   ORDER BY s.nama";
                   
    $stmt_siswa = mysqli_prepare($conn, $query_siswa);
    if ($stmt_siswa === false) {
        showErrorAndDie("Error preparing siswa query: " . mysqli_error($conn));
    }
    
    if (!mysqli_stmt_bind_param($stmt_siswa, "s", $kelas)) {
        showErrorAndDie("Error binding siswa parameters: " . mysqli_stmt_error($stmt_siswa));
    }
    
    if (!mysqli_stmt_execute($stmt_siswa)) {
        showErrorAndDie("Error executing siswa query: " . mysqli_stmt_error($stmt_siswa));
    }
    
    $result_siswa = mysqli_stmt_get_result($stmt_siswa);
    if ($result_siswa === false) {
        showErrorAndDie("Error getting siswa result: " . mysqli_error($conn));
    }

    // Header Excel
    header("Content-Type: application/vnd.ms-excel");
    header("Content-Disposition: attachment; filename=laporan_absensi_".$kelas."_".date('Y-m-d').".xls");
    header("Pragma: no-cache");
    header("Expires: 0");

    // 3. Buat template Excel
    echo "<table border='1'>";
    
    // Header tabel
    echo "<tr>";
    echo "<th>No</th>";
    echo "<th>NIS</th>";
    echo "<th>Nama</th>";
    foreach ($tanggal_headers as $tgl) {
        echo "<th>".date('d/m', strtotime($tgl))."</th>";
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
            $query_absen = "SELECT 1 FROM absensi 
                           WHERE nis = ? 
                           AND DATE(tanggal) = ?";
            
            $stmt_absen = mysqli_prepare($conn, $query_absen);
            if ($stmt_absen === false) {
                showErrorAndDie("Error preparing absen query: " . mysqli_error($conn));
            }
            
            if (!mysqli_stmt_bind_param($stmt_absen, "ss", $siswa['nis'], $tgl)) {
                showErrorAndDie("Error binding absen parameters: " . mysqli_stmt_error($stmt_absen));
            }
            
            if (!mysqli_stmt_execute($stmt_absen)) {
                showErrorAndDie("Error executing absen query: " . mysqli_stmt_error($stmt_absen));
            }
            
            mysqli_stmt_store_result($stmt_absen);
            $hadir = (mysqli_stmt_num_rows($stmt_absen) > 0) ? '&#x2713' : '';
            
            if ($hadir) $total_hadir++;
            
            echo "<td style='text-align:center'>".$hadir."</td>";
            mysqli_stmt_close($stmt_absen);
        }
        
        echo "<td style='text-align:center'>".$total_hadir."</td>";
        echo "</tr>";
    }
    
    echo "</table>";
    mysqli_stmt_close($stmt_siswa);
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