<?php
include 'koneksi.php';
session_start();

if (!isset($_SESSION['username'])) {
    header("location: index.php");
    exit();
}

// Ambil daftar kelas untuk dropdown
$query_kelas = "SELECT Id, nama_kelas FROM kelas ORDER BY nama_kelas";
$result_kelas = mysqli_query($conn, $query_kelas);

// --- PROSES SUBMIT (harus sebelum ada output HTML) --- //
$success = "";
$error   = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Ambil & sanitasi input
    $nis      = mysqli_real_escape_string($conn, $_POST['nis'] ?? "");
    $nama     = mysqli_real_escape_string($conn, $_POST['nama'] ?? "");
    $id_kelas = (int)($_POST['id_kelas'] ?? 0);

    // Validasi dasar
    if ($nis === "" || $nama === "" || $id_kelas <= 0) {
        $error = "Semua field wajib diisi.";
    } else {
        // Ambil nama_kelas dari Id biar bisa disimpan juga (kalau kolom 'kelas' masih dipakai)
        $qK = mysqli_query($conn, "SELECT nama_kelas FROM kelas WHERE Id={$id_kelas} LIMIT 1");
        if (!$qK || mysqli_num_rows($qK) === 0) {
            $error = "Kelas tidak valid.";
        } else {
            $rowK = mysqli_fetch_assoc($qK);
            $kelasNama = $rowK['nama_kelas'];

            // Upload foto (wajib sesuai form kamu)
            if (!empty($_FILES['foto']['name'])) {
                $folder_upload = "images/";
                if (!is_dir($folder_upload)) {
                    @mkdir($folder_upload, 0777, true);
                }

                $oriName   = $_FILES['foto']['name'];
                $tmpName   = $_FILES['foto']['tmp_name'];
                $ext       = strtolower(pathinfo($oriName, PATHINFO_EXTENSION));
                $allowed   = ['jpg','jpeg','png','gif'];

                if (!in_array($ext, $allowed)) {
                    $error = "Format gambar harus JPG, JPEG, PNG, atau GIF.";
                } else {
                    // Nama file unik untuk menghindari tabrakan
                    $foto = time() . '_' . preg_replace('/\s+/', '_', basename($oriName));
                    $target = $folder_upload . $foto;

                    if (!move_uploaded_file($tmpName, $target)) {
                        $error = "Gagal mengupload foto.";
                    } else {
                        // Insert data
                        $sql = "INSERT INTO data_siswa (nis, nama, kelas, foto, id_kelas)
                                VALUES ('{$nis}', '{$nama}', '{$kelasNama}', '{$foto}', {$id_kelas})";
                        if (mysqli_query($conn, $sql)) {
                            // redirect sebelum ada output
                            header("Location: data_siswa.php");
                            exit();
                        } else {
                            $error = "Gagal menyimpan data: " . mysqli_error($conn);
                        }
                    }
                }
            } else {
                $error = "Foto wajib diunggah.";
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Tambah Siswa - Absensi Sekolah</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-200 min-h-screen flex">

  <!-- SIDEBAR / NAVBAR -->
  <?php include 'sidebar.php'; ?>

  <!-- KONTEN UTAMA -->
  <main class="ml-64 flex-1 p-10">
    <h1 class="text-4xl font-bold text-blue-600 mb-8 text-center">Form Tambah Siswa</h1>

    <?php if ($error): ?>
      <div class="max-w-2xl mx-auto mb-6 bg-red-100 text-red-700 p-3 rounded"><?php echo $error; ?></div>
    <?php endif; ?>
    <?php if ($success): ?>
      <div class="max-w-2xl mx-auto mb-6 bg-green-100 text-green-700 p-3 rounded"><?php echo $success; ?></div>
    <?php endif; ?>

    <form method="POST" enctype="multipart/form-data" class="max-w-2xl mx-auto space-y-8">
      <!-- Nama -->
      <div>
        <label for="nama" class="block text-lg font-medium text-gray-700 mb-1">Nama Lengkap</label>
        <input type="text" id="nama" name="nama" required
          class="w-full bg-transparent border-b-2 border-blue-400 text-gray-800 py-2 focus:outline-none focus:border-blue-600 placeholder-gray-400"
          placeholder="Masukkan nama siswa" value="<?php echo htmlspecialchars($_POST['nama'] ?? ''); ?>">
      </div>

      <!-- NIS -->
      <div>
        <label for="nis" class="block text-lg font-medium text-gray-700 mb-1">NIS</label>
        <input type="text" id="nis" name="nis" required
          class="w-full bg-transparent border-b-2 border-blue-400 text-gray-800 py-2 focus:outline-none focus:border-blue-600 placeholder-gray-400"
          placeholder="Masukkan NIS" value="<?php echo htmlspecialchars($_POST['nis'] ?? ''); ?>">
      </div>

      <!-- Kelas -->
      <div>
        <label for="id_kelas" class="block text-lg font-medium text-gray-700 mb-1">Kelas</label>
        <select id="id_kelas" name="id_kelas" required
            class="w-full bg-transparent border-b-2 border-blue-400 text-gray-800 py-2 focus:outline-none focus:border-blue-600">
            <option value="" disabled <?php echo empty($_POST['id_kelas']) ? 'selected' : ''; ?>>Pilih Kelas</option>
            <?php
            if ($result_kelas && mysqli_num_rows($result_kelas) > 0) {
                while ($row_kelas = mysqli_fetch_assoc($result_kelas)) {
                    $sel = (isset($_POST['id_kelas']) && (int)$_POST['id_kelas'] === (int)$row_kelas['Id']) ? 'selected' : '';
                    echo '<option value="' . (int)$row_kelas['Id'] . "\" {$sel}>" . htmlspecialchars($row_kelas['nama_kelas']) . '</option>';
                }
            }
            ?>
        </select>
      </div>

      <!-- Foto -->
      <div>
        <label for="foto" class="block text-lg font-medium text-gray-700 mb-1">Foto Profil</label>
        <input type="file" id="foto" name="foto" accept="image/*" required
              class="w-full bg-transparent border-b-2 border-blue-400 text-gray-800 py-2 focus:outline-none focus:border-blue-600 placeholder-gray-400">
      </div>

      <!-- Tombol -->
      <div class="pt-2">
        <button type="submit"
          class="w-full bg-blue-500 hover:bg-blue-600 text-white font-semibold py-3 rounded-lg transition">
          Simpan Siswa
        </button>
      </div>

      <div class="text-center">
        <a href="data_siswa.php" class="text-blue-600 hover:underline text-sm">← Kembali ke Data Siswa</a>
      </div>
    </form>
  </main>

</body>
</html>
