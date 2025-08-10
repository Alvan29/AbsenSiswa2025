<?php
  include 'koneksi.php';
  session_start();

  if (!isset($_SESSION['username'])){
    header("location: index.php");
    exit();
  }

  if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['nama_kelas'])) {
    $nama_kelas = mysqli_real_escape_string($conn, $_POST['nama_kelas']);
    
    $query = "INSERT INTO kelas (nama_kelas) VALUES ('$nama_kelas')";
    if (mysqli_query($conn, $query)) {
        $success = "Kelas berhasil ditambahkan";
    } else {
        $error = "Gagal menambahkan kelas: " . mysqli_error($conn);
    }
  }
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Data Kelas dan Jurusan</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="css/style.css" rel="stylesheet">
</head>
<body class="flex bg-gray-200">

  <!-- Sidebar -->
  <?php include 'sidebar.php'; ?>
  <?php include 'logout_modal.php'; ?>

  <!-- Konten Utama -->
  <main class="flex-1 p-6">
    <div class="grid grid-cols-1 gap-6">

      <!-- Daftar Kelas -->
      <div class="bg-white rounded-lg shadow">
        <div class="flex justify-between items-center p-4 border-b">
          <div>
            <h2 class="font-semibold">Daftar Kelas</h2>
            <p class="text-xs text-gray-500">2024-2025</p>
          </div>
          <div class="flex gap-2">
            <button id="btnTambahKelas" class="text-xl">➕</button>
            <button id="btnRefreshKelas" class="text-xl">🔄</button>
          </div>
        </div>
        <div id="formTambahKelas" class="hidden p-4 border-b">
            <form id="formKelas" method="POST" autocomplete="off">
            <input type="text" name="nama_kelas" placeholder="Nama Kelas" class="w-full px-3 py-2 border rounded mb-2" required>
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Simpan</button>
          </form>
        </div>
        <div id="listKelas" class="p-4 text-gray-600 text-sm">
          <!-- Daftar kelas akan dimuat di sini oleh backend -->
        </div>
         <table class="w-full table-auto border border-collapse">
      <thead class="bg-gray-200">
        <tr>
          <th class="border p-2">No</th>
          <th class="border p-2">Kelas</th>
          <th class="border p-2">Jumlah Siswa</th>
        </tr>
      </thead>
      <tbody>
        <?php
          $query = "SELECT k.Id AS id_kelas, k.nama_kelas, COUNT(s.nis) AS jumlah_siswa 
                    FROM kelas k LEFT JOIN data_siswa s ON k.Id = s.id_kelas 
                    GROUP BY k.Id, k.nama_kelas ORDER BY k.nama_kelas";
          $result = mysqli_query($conn, $query);
          if (!$result) {
              die("Query error: " . mysqli_error($conn));
          }
          
          $no = 1;
          while ($row = mysqli_fetch_assoc($result)) {
              echo "<tr class='hover:bg-gray-50'>";
              echo "<td class='border p-3'>" . $no++ . "</td>";
              echo "<td class='border p-3 font-medium'>" . htmlspecialchars($row['nama_kelas']) . "</td>";
              echo "<td class='border p-3'>" . $row['jumlah_siswa'] . " siswa</td>";
              echo "</tr>";
          }
          
          if (mysqli_num_rows($result) == 0) {
              echo "<tr><td colspan='4' class='border p-3 text-center text-gray-500'>Belum ada data kelas</td></tr>";
          }
        ?>
      </tbody>
    </table>
      </div>

    </div>
  </main>

   <script>
    // Toggle form tambah kelas
    document.getElementById("btnTambahKelas").addEventListener("click", () => {
      const form = document.getElementById("formTambahKelas");
      form.classList.toggle("hidden");
      
      if (!form.classList.contains("hidden")) {
        document.getElementById("nama_kelas").focus();
      }
    });

    // Refresh page
    document.getElementById("btnRefreshKelas").addEventListener("click", () => {
      window.location.reload();
    });
  </script>

</body>
</html>
