<!-- sidebar.php -->
<aside class="w-64 min-h-screen bg-gray-800 text-white flex flex-col justify-between py-6 px-4">
  <div>
    <!-- Logo -->
    <div class="flex justify-center mb-10">
      <img src="images-removebg-preview.png" alt="Logo" class="w-24 h-24 object-contain">
    </div>

    <!-- Menu -->
    <?php $current = basename($_SERVER['PHP_SELF']); ?>
    <nav class="space-y-4 text-sm font-bold uppercase tracking-wider">
      <!-- <a href="absen.php" class="block px-4 py-2 rounded <?= $current == 'absen.php' ? 'bg-blue-700' : 'hover:bg-blue-600' ?>">Mau absen?</a> -->
      <a href="dashboard.php" class="block px-4 py-2 rounded <?= $current == 'dashboard.php' ? 'bg-blue-700' : 'hover:bg-blue-600' ?>">Dashboard</a>
      <a href="data_siswa.php" class="block px-4 py-2 rounded <?= $current == 'data_siswa.php' ? 'bg-blue-700' : 'hover:bg-blue-600' ?>">Data Siswa</a>
      <a href="kelas_jurusan.php" class="block px-4 py-2 rounded <?= $current == 'kelas_jurusan.php' ? 'bg-blue-700' : 'hover:bg-blue-600' ?>">Kelas & Jurusan</a>
      <a href="laporan.php" class="block px-4 py-2 rounded <?= $current == 'laporan.php' ? 'bg-blue-700' : 'hover:bg-blue-600' ?>">Laporan</a>
    </nav>
  </div>

  <!-- Logout -->

  <div class="px-4">
    <button onclick="toggleLogoutModal()" class="block px-4 py-2 text-sm font-bold uppercase tracking-wider hover:bg-blue-600 rounded text-left w-full">
      Logout
    </button>
  </div>

</aside>
