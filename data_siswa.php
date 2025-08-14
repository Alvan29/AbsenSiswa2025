<?php
include 'koneksi.php';
session_start();

if (!isset($_SESSION['username'])) {
    header("location: index.php");
    exit();
}

$resultKelas = mysqli_query($conn, "SELECT Id, nama_kelas FROM kelas ORDER BY nama_kelas ASC");
if (!$resultKelas) {
    die("Query error: " . mysqli_error($conn));
}

$where = "";
if (!empty($_GET['kelas'])) {
    $id_kelas = mysqli_real_escape_string($conn, $_GET['kelas']);
    $where = "WHERE s.id_kelas = '$id_kelas'";
}

$query = mysqli_query($conn, "
    SELECT s.id, s.nis, s.nama, k.nama_kelas, s.foto
    FROM data_siswa s
    LEFT JOIN kelas k ON s.id_kelas = k.Id
    $where
    ORDER BY s.nama ASC
");
if (!$query) {
    die("Query error: " . mysqli_error($conn));
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Data Siswa - Absensi Sekolah</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="css/style.css" rel="stylesheet">
</head>
<body class="flex">

<?php include 'sidebar.php'; ?>
<?php include 'logout_modal.php'; ?>

<main class="flex-1 p-8 bg-gray-100 min-h-screen">
  <h1 class="text-2xl font-bold text-gray-800 mb-6">Data Siswa</h1>

  <div class="bg-white p-6 rounded-lg shadow mb-6">
    <form action="data_siswa.php" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
      <div>
        <label for="filter_kelas" class="block text-sm font-medium text-gray-700 mb-1">Kelas</label>
        <select name="kelas" id="filter_kelas"
          class="w-full border-b-2 border-black bg-transparent py-2 text-gray-800 focus:outline-none focus:border-black">
          <option value="">Semua Kelas</option>
          <?php while ($rowKelas = mysqli_fetch_assoc($resultKelas)) { ?>
            <option value="<?= $rowKelas['Id']; ?>" <?= (!empty($_GET['kelas']) && $_GET['kelas'] == $rowKelas['Id']) ? 'selected' : ''; ?>>
              <?= htmlspecialchars($rowKelas['nama_kelas']); ?>
            </option>
          <?php } ?>
        </select>
      </div>
      <div class="flex items-end">
        <button type="submit"
          class="w-full bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 rounded-lg transition">
          Terapkan Filter
        </button>
      </div>
      <div class="flex items-end">
        <a href="tambah_siswa.php" 
          class="w-full bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 rounded-lg transition text-center">
          + Tambah Siswa
        </a>
      </div>
    </form>
  </div>

  <!-- Tabel Siswa -->
  <div class="overflow-x-auto">
    <table class="min-w-full bg-white rounded-lg shadow">
      <thead class="bg-gray-800 text-white text-left text-sm uppercase tracking-wider">
        <tr>
          <th class="px-6 py-3">No</th>
          <th class="px-6 py-3">NIS</th>
          <th class="px-6 py-3">Nama</th>
          <th class="px-6 py-3">Kelas</th>
          <th class="px-6 py-3">Foto</th>
          <th class="px-6 py-3">Aksi</th>
        </tr>
      </thead>
      <tbody class="text-gray-700 text-sm divide-y divide-gray-200">
        <?php 
        $no = 1;
        while ($data = mysqli_fetch_assoc($query)) {
          echo "<tr>";
          echo "<td class='px-6 py-4'>" . $no++ . "</td>";
          echo "<td class='px-6 py-4'>" . htmlspecialchars($data['nis']) . "</td>";
          echo "<td class='px-6 py-4'>" . htmlspecialchars($data['nama']) . "</td>";
          echo "<td class='px-6 py-4'>" . htmlspecialchars($data['nama_kelas']) . "</td>";
          echo "<td class='px-6 py-4'>";
            if (!empty($data['foto'])) {
              echo "<img src='images/" . htmlspecialchars($data['foto']) . "' alt='foto' class='w-12 h-16 object-cover rounded'>";
            } else {
              echo "-";
            }
          echo "</td>";
          echo "<td class='px-6 py-4'>";
            echo "<a href='edit_siswa.php?id=" . $data['id'] . "' class='bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded text-sm mr-2'>Edit</a>";
            echo "<button onclick=\"showHapusModal('" . $data['id'] . "')\" class='bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded text-sm'>Hapus</button>";
          echo "</td>";
          echo "</tr>";
        }
        ?>
      </tbody>
    </table>
  </div>

  <!-- Hapus Modal -->
  <div id="hapusModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
    <div class="bg-white p-6 rounded-lg shadow-lg max-w-sm w-full">
      <h2 class="text-lg font-semibold mb-4 text-gray-800 text-center">Yakin hapus data?</h2>
      <div class="flex justify-end gap-3">
        <button onclick="toggleHapusModal()" class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded">Tidak</button>
        <a id="confirmDeleteBtn" href="#" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded">Iya</a>
      </div>
    </div>
  </div>
</main>

<script>
  function toggleHapusModal() {
    document.getElementById("hapusModal").classList.toggle("hidden"); 
  }
  function showHapusModal(id) {
    document.getElementById('confirmDeleteBtn').href = 'hapus_siswa.php?id=' + id;
    document.getElementById('hapusModal').classList.remove('hidden');
  }
  document.getElementById('filter_kelas').addEventListener('change', function() {
    const selected = this.value;
    window.location.href = 'data_siswa.php?kelas=' + selected;
  });
</script>
</body>
</html>
