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
    $today = date('Y-m-d');
    $now = date('H:i:s');
    $ip_address = $_SERVER['REMOTE_ADDR'];
    $query = "INSERT INTO absensi (nis, tanggal, waktu, ip_address) VALUES (?, NOW(), NOW(), ?)";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "ss", $nis, $ip_address);
    mysqli_stmt_execute($stmt);
    return mysqli_query($conn, $query);
}

// Fungsi untuk mendapatkan riwayat absensi terbaru
function getRiwayatAbsensi($conn, $limit = 10) {
    $query = "SELECT a.*, s.nama, s.kelas, s.foto 
              FROM absensi a 
              JOIN data_siswa s ON a.nis = s.nis 
              ORDER BY a.tanggal DESC, a.waktu DESC 
              LIMIT $limit";
              
    $result = mysqli_query($conn, $query);
    
    // Tambahkan pengecekan error
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
    
    // Validasi NIS tidak kosong
    if (!empty($nis)) {
        // Cek apakah siswa ada di database
        $siswa = getSiswa($nis, $conn);
        
        if ($siswa) {
            // Cek apakah sudah absen hari ini
            if (!sudahAbsen($nis, $conn)) {
                // Catat absensi
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
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Absensi Siswa</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    function updateClock() {
      const now = new Date();
      const jam = now.toLocaleTimeString('id-ID', { hour12: false });
      const hari = now.toLocaleDateString('id-ID', {
        weekday: 'long',
        year: 'numeric',
        month: 'long',
        day: 'numeric'
      });

      document.getElementById('clock').textContent = jam;
      document.getElementById('tanggal').textContent = hari;
    }
    setInterval(updateClock, 1000);
    window.onload = updateClock;
  </script>
</head>
<body class="bg-gray-200 min-h-screen flex items-center justify-center font-sans">

  <div class="flex flex-col md:flex-row items-center justify-center w-full max-w-screen-xl px-4 py-10 gap-14">

    <!-- Logo Besar -->
    <div class="w-64 h-64 rounded-xl overflow-hidden flex items-center justify-center">
      <img src="images-removebg-preview.png" alt="Logo Sekolah" class="w-full h-full object-contain">
    </div>
 
    <!-- Tengah -->
    <div class="text-center space-y-5">
      <h1 class="text-2xl font-semibold text-gray-800">Absensi Sekolah</h1>

      <div class="text-6xl font-bold text-gray-900" id="clock">00:00:00</div>
      <div class="text-lg text-gray-700" id="tanggal">Senin, 1 Januari 2025</div>

      <form method="POST" action="" class="flex flex-col items-center">
        <input type="text" name="nis" placeholder="MASUKKAN NIS ANDA"
          class="w-80 px-4 py-3 mt-4 rounded-lg border border-gray-300 text-center text-xl shadow-md focus:outline-none focus:ring-2 focus:ring-blue-400"
          autocomplete="off" autofocus>
        
        <?php if (!empty($pesan)): ?>
          <div class="mt-2 text-sm <?php echo strpos($pesan, 'berhasil') !== false ? 'text-green-600' : 'text-red-600'; ?>">
            <?php echo $pesan; ?>
          </div>
        <?php endif; ?>
        
        <?php if ($show_info): ?>
          <div class="mt-4 p-3 bg-white rounded-lg shadow-md w-full">
            <div class="font-semibold"><?php echo $nama_siswa; ?></div>
            <div class="text-gray-600"><?php echo $kelas_siswa; ?></div>
          </div>
        <?php endif; ?>
      </form>

      <div>
        <a href="login.php"
           class="text-sm mt-2 inline-block px-5 py-2 text-gray-700 bg-gray-200 rounded-md hover:bg-gray-300">
          Kamu Admin?
        </a>
      </div>
    </div>

    <!-- Histori Absen -->
    <div class="w-80 bg-white rounded-xl shadow-lg p-4">
      <h2 class="text-center font-semibold mb-3 text-lg">Absen Terbaru</h2>
      <div class="h-64 overflow-y-auto border-t pt-2">
        <?php if (empty($riwayat_absen)): ?>
          <p class="text-center text-sm text-gray-400">Belum ada data</p>
        <?php else: ?>
          <ul class="divide-y">
            <?php foreach ($riwayat_absen as $absen): ?>
              <li class="py-2">
                <div class="flex justify-between items-center">
                  <div>
                    <?php echo '<img src="images/'.$absen['foto'].'" alt="Foto Profil" class="w-24 h-24 rounded-full">'; ?>
                  </div>
                  <div>
                    <div class="font-medium"><?php echo $absen['nama']; ?></div>
                    <div class="text-sm text-gray-500"><?php echo $absen['kelas']; ?></div>
                  </div>
                  <div class="text-xs text-gray-400 text-right">
                    <div><?php echo date('H:i', strtotime($absen['waktu'])); ?></div>
                    <div><?php echo date('d/m/Y', strtotime($absen['tanggal'])); ?></div>
                  </div>
                </div>
              </li>
            <?php endforeach; ?>
          </ul>
        <?php endif; ?>
      </div>
    </div>

  </div>

</body>
</html>