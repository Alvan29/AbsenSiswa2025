<?php include 'koneksi.php'; ?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Absensi Sekolah</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans text-gray-800">

  <div class="max-w-3xl mx-auto mt-10 bg-white shadow-lg rounded-lg p-6">
    <h1 class="text-2xl font-bold text-center mb-6 text-blue-600">Form Absensi Siswa</h1>

    <?php
    // Simpan data jika form disubmit
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
      $nis = $_POST['nis'];
      $nama = $_POST['nama'];
      $kelas = $_POST['kelas'];

      $query = "INSERT INTO data_siswa (nis, nama, kelas) VALUES ('$nis', '$nama', '$kelas')";
      $result = mysqli_query($conn, $query);

      if ($result) {
        echo '<div class="bg-green-100 text-green-700 p-3 mb-4 rounded">Absensi berhasil disimpan!</div>';
      } else {
        echo '<div class="bg-red-100 text-red-700 p-3 mb-4 rounded">Gagal menyimpan data.</div>';
      }
    }
    ?>

    <form method="POST" class="mb-8">
      <div class="mb-4">
        <label class="block mb-1">NIS</label>
        <input type="text" name="nis" required
          class="w-full border p-2 rounded focus:outline-none focus:ring-2 focus:ring-blue-400">
      </div>

      <div class="mb-4">
        <label class="block mb-1">Nama</label>
        <input type="text" name="nama" required
          class="w-full border p-2 rounded focus:outline-none focus:ring-2 focus:ring-blue-400">
      </div>

      <!-- <div class="mb-4">
        <label class="block mb-1">Status</label>
        <select name="status" required
          class="w-full border p-2 rounded focus:outline-none focus:ring-2 focus:ring-blue-400">
          
          <option value="Hadir">Hadir</option>
          <option value="Izin">Izin</option>
          <option value="Sakit">Sakit</option>
          <option value="Alpha">Alpha</option>
        </select>
      </div> -->

      <button type="submit"
        class="w-full bg-blue-500 text-white py-2 rounded hover:bg-blue-600 transition">
        Simpan Absensi
      </button>
    </form>

    <h2 class="text-xl font-semibold mb-4">Rekap Absensi</h2>
    <table class="w-full table-auto border border-collapse">
      <thead class="bg-gray-200">
        <tr>
          <th class="border p-2">No</th>
          <th class="border p-2">NIS</th>
          <th class="border p-2">Nama</th>
          <th class="border p-2">Status</th>
          <th class="border p-2">Waktu</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $data = mysqli_query($conn, "SELECT * FROM absensi ORDER BY waktu DESC");
        $no = 1;
        while ($row = mysqli_fetch_assoc($data)) {
          echo "<tr class='text-center'>";
          echo "<td class='border p-2'>" . $no++ . "</td>";
          echo "<td class='border p-2'>" . $row['nis'] . "</td>";
          echo "<td class='border p-2'>" . $row['nama'] . "</td>";
          echo "<td class='border p-2'>" . $row['status'] . "</td>";
          echo "<td class='border p-2'>" . $row['waktu'] . "</td>";
          echo "</tr>";
        }
        ?>
      </tbody>
    </table>

  </div>

</body>
</html>
