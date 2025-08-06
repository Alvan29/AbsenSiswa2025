<?php include 'koneksi.php'; 
  session_start();
  $query_kelas = "SELECT * FROM kelas ORDER BY nama_kelas";
  $result_kelas = mysqli_query($conn, $query_kelas);
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
    <h1 class="text-4xl font-bold text-blue-600 mb-12 text-center">Form Tambah Siswa</h1>

    <form  method="POST" enctype="multipart/form-data" class="max-w-2xl mx-auto space-y-10">
      
      <!-- Nama -->
      <div>
        <label for="nama" class="block text-lg font-medium text-gray-700 mb-1">Nama Lengkap</label>
        <input type="text" id="nama" name="nama" required
          class="w-full bg-transparent border-b-2 border-blue-400 text-gray-800 py-2 focus:outline-none focus:border-blue-600 placeholder-gray-400"
          placeholder="Masukkan nama siswa">
      </div>

      <!-- NIS -->
      <div>
        <label for="nis" class="block text-lg font-medium text-gray-700 mb-1">NIS</label>
        <input type="text" id="nis" name="nis" required
          class="w-full bg-transparent border-b-2 border-blue-400 text-gray-800 py-2 focus:outline-none focus:border-blue-600 placeholder-gray-400"
          placeholder="Masukkan NIS">
      </div>

      <!-- Kelas -->
      <div>
        <label for="kelas" class="block text-lg font-medium text-gray-700 mb-1">Kelas</label>
        <select id="kelas" name="kelas"
            class="w-full bg-transparent border-b-2 border-blue-400 text-gray-800 py-2 focus:outline-none focus:border-blue-600">
            <option value="" disabled selected>Pilih Kelas</option>
            <?php
            // Tampilkan opsi kelas dari database
            while ($row_kelas = mysqli_fetch_assoc($result_kelas)) {
                echo '<option value="' . htmlspecialchars($row_kelas['nama_kelas']) . '">' 
                    . htmlspecialchars($row_kelas['nama_kelas']) . '</option>';
            }
            ?>
        </select>
      </div>

      <div>
        <label for="foto" class="block text-lg font-medium text-gray-700 mb-1">Foto Profil</label>
        <input type="file" id="foto" name="foto" accept="image/*" required
              class="w-full bg-transparent border-b-2 border-blue-400 text-gray-800 py-2 focus:outline-none focus:border-blue-600 placeholder-gray-400">
      </div>

      <!-- Tombol -->
      <div class="pt-4">
        <button type="submit"
          class="w-full bg-blue-500 hover:bg-blue-600 text-white font-semibold py-3 rounded-lg transition">
          Simpan Siswa
        </button>
      </div>

      <div class="text-center">
        <a href="data_siswa.php" class="text-blue-600 hover:underline text-sm">← Kembali ke Data Siswa</a>
      </div>
    </form>

    <!-- Proses tambah data siswa -->
    <?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validasi input text
    $nis = mysqli_real_escape_string($conn, $_POST['nis']);
    $nama = mysqli_real_escape_string($conn, $_POST['nama']);
    $kelas = mysqli_real_escape_string($conn, $_POST['kelas']);

    $foto = $_FILES['foto']['name'];
    $temp_file = $_FILES['foto']['tmp_name'];
    $folder_upload = "images/";

    // Cek apakah file yang diunggah adalah gambar
    $allowed_extensions = array("jpg", "jpeg", "png", "gif");
    $file_extension = strtolower(pathinfo($foto, PATHINFO_EXTENSION));

    if (!in_array($file_extension, $allowed_extensions)) {
        die("Maaf, hanya format JPG, JPEG, PNG, dan GIF yang diperbolehkan.");
    }

    // Pindahkan file yang diunggah ke folder uploads
    $uploaded_file = $folder_upload . $foto;

    // Cek kelas valid
    $check_kelas = mysqli_query($conn, "SELECT Id FROM kelas WHERE nama_kelas = '$kelas'");
    if (mysqli_num_rows($check_kelas) == 0) {
        die('<div class="bg-red-100 text-red-700 p-3 mb-4 rounded">Kelas tidak valid.</div>');
    }
    $kelas_data = mysqli_fetch_assoc($check_kelas);
    $id_kelas = $kelas_data['Id'];

    if (move_uploaded_file($temp_file, $uploaded_file)){
        $query = mysqli_query($conn, "INSERT INTO data_siswa (nis, nama, kelas, foto, id_kelas) 
                                      VALUES ('$nis', '$nama', '$kelas', '$foto', '$id_kelas')");
        if (!$query){
          die("Error: " . mysqli_error($conn));
        }else{
          $success = "Berhasil menambahkan siswa";
        }
    }
  }    
?>
  </main>

</body>
</html>
