<?php
include 'koneksi.php';

// --- Pagination --- //
$limit = 10; // jumlah data per halaman
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// Ambil total data
$totalResult = mysqli_query($conn, "SELECT COUNT(*) as total FROM kelas");
$totalData = mysqli_fetch_assoc($totalResult)['total'];
$totalPages = ceil($totalData / $limit);

// Ambil data kelas dengan limit dan offset
$query = "SELECT * FROM kelas LIMIT $limit OFFSET $offset";
$result = mysqli_query($conn, $query);
session_start();

if (!isset($_SESSION['username'])){
    header("location: index.php");
    exit();
}

// Tambah kelas baru
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['nama_kelas'])) {
    $nama_kelas = mysqli_real_escape_string($conn, $_POST['nama_kelas']);
    $query = "INSERT INTO kelas (nama_kelas) VALUES ('$nama_kelas')";
    if (mysqli_query($conn, $query)) {
        $success = "Kelas berhasil ditambahkan";
    } else {
        $error = "Gagal menambahkan kelas: " . mysqli_error($conn);
    }
}

// Hapus kelas jika ada request GET
if (isset($_GET['hapus'])) {
    $id_hapus = intval($_GET['hapus']);
    // Pastikan tidak ada siswa di kelas ini
    $cek = mysqli_query($conn, "SELECT COUNT(*) AS jml FROM data_siswa WHERE id_kelas=$id_hapus");
    $hasil = mysqli_fetch_assoc($cek);
    if ($hasil['jml'] > 0) {
        $error = "Kelas tidak bisa dihapus karena masih ada siswa di dalamnya!";
    } else {
        mysqli_query($conn, "DELETE FROM kelas WHERE Id = $id_hapus");
        header("Location: kelas_jurusan.php");
        exit();
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
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    function showHapusModal(id) {
      document.getElementById('hapusId').value = id;
      document.getElementById('hapusModal').classList.remove('hidden');
    }
    function closeHapusModal() {
      document.getElementById('hapusModal').classList.add('hidden');
    }
    function confirmHapus() {
      var id = document.getElementById('hapusId').value;
      window.location.href = 'kelas_jurusan.php?hapus=' + id;
    }
  </script>
</head>
<body class="flex bg-gray-200">

  <!-- Sidebar -->
  <?php include 'sidebar.php'; ?>
  <?php include 'logout_modal.php'; ?>

  <!-- Konten Utama -->
  <main class="flex-1 p-6">
    <div class="grid grid-cols-1 gap-6">

      <!-- Pesan error/sukses -->
      <?php if (!empty($success)): ?>
        <div class="bg-green-100 text-green-700 p-3 rounded"><?php echo $success; ?></div>
      <?php endif; ?>
      <?php if (!empty($error)): ?>
        <div class="bg-red-100 text-red-700 p-3 rounded"><?php echo $error; ?></div>
      <?php endif; ?>

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
            <input type="text" name="nama_kelas" id="nama_kelas" 
                   placeholder="Nama Kelas" 
                   class="w-full px-3 py-2 border rounded mb-2" required>
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">
              Simpan
            </button>
          </form>
        </div>

        <table class="w-full table-auto border border-collapse">
          <thead class="bg-gray-200">
            <tr>
              <th class="border p-2">No</th>
              <th class="border p-2">Kelas</th>
              <th class="border p-2">Jumlah Siswa</th>
              <th class="border p-2">Aksi</th>
            </tr>
          </thead>
            <tbody>
            <?php
            $query = "SELECT k.Id AS id_kelas, k.nama_kelas, COUNT(s.nis) AS jumlah_siswa 
                      FROM kelas k 
                      LEFT JOIN data_siswa s ON k.Id = s.id_kelas 
                      GROUP BY k.Id, k.nama_kelas 
                      ORDER BY k.nama_kelas 
                      LIMIT $limit OFFSET $offset";
            $result = mysqli_query($conn, $query);

            if (!$result) {
                die('Query error: ' . mysqli_error($conn));
            }

            $no = $offset + 1;
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr class='hover:bg-gray-50'>";
                echo "<td class='border p-3 text-center'>" . $no++ . "</td>";
                echo "<td class='border p-3 font-medium'>" . htmlspecialchars($row['nama_kelas']) . "</td>";
                echo "<td class='border p-3 text-center'>" . $row['jumlah_siswa'] . " siswa</td>";
                echo "<td class='border p-3 text-center'>";
                echo "<button onclick=\"showHapusModal('" . $row['id_kelas'] . "')\" class='bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded text-sm'>Hapus</button>";
                echo "</td>";
                echo "</tr>";
            }
            ?>
            </tbody>
          </table>

            <!-- Pagination -->
    <div class="flex justify-center items-center mt-4 space-x-2">
        <?php if ($page > 1): ?>
            <a href="?page=<?= $page - 1 ?>" 
               class="bg-gray-300 hover:bg-gray-400 text-black px-3 py-1 rounded">Prev</a>
        <?php endif; ?>

        <span class="px-3 py-1">Halaman <?= $page ?> dari <?= $totalPages ?></span>

        <?php if ($page < $totalPages): ?>
            <a href="?page=<?= $page + 1 ?>" 
               class="bg-gray-300 hover:bg-gray-400 text-black px-3 py-1 rounded">Next</a>
        <?php endif; ?>
    </div>

      </div>

    </div>
  </main>

  <!-- Modal Hapus -->
  <div id="hapusModal" class="hidden fixed inset-0 flex items-center justify-center bg-black bg-opacity-50">
    <div class="bg-white rounded p-6 w-80 shadow-lg">
      <h2 class="text-lg font-bold mb-4">Konfirmasi Hapus</h2>
      <p>Yakin ingin menghapus kelas ini?</p>
      <input type="hidden" id="hapusId">
      <div class="flex justify-end mt-4">
        <button onclick="closeHapusModal()" class="bg-gray-300 hover:bg-gray-400 text-black px-4 py-2 rounded mr-2">Batal</button>
        <button onclick="confirmHapus()" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded">Hapus</button>
      </div>
    </div>
  </div>

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
    <script>
        function showHapusModal(id) {
            if (confirm("Yakin ingin menghapus kelas ini? Jika kelas memiliki siswa, data tidak dapat dihapus.")) {
                window.location.href = "hapus_kelas.php?id=" + id;
            }
        }
      </script>
</body>
</html>
