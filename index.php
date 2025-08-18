<?php
  include 'koneksi.php';
  include "proses_absen.php";

// <!-- jikalaau ingin di tambahkan query pembatas untuk tabel absen terakhir ada di sini silahkan di matikan comand nya  -->
// Ambil data 10 absen terakhir untuk bisa di display
$query = "
    SELECT s.nama, a.waktu 
    FROM absensi a
    JOIN siswa s ON a.nis = s.nis
    ORDER BY a.tanggal DESC, a.waktu DESC
    LIMIT 10
";
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Absensi Siswa</title>
    <link href="css/output.css" rel="stylesheet">
</head>
<body class="bg-white text-gray-800">

    <!-- Navbar -->
    <nav class="flex items-center justify-between px-8 py-4">
        <div class="font-bold text-lg">TKJ SEKOLAHMU</div>
        <div class="flex items-center gap-6">
            <a href="#" class="hover:underline">GITHUB</a>
            <a href="https://www.instagram.com/topman2cianjur/" class="hover:underline">INSTAGRAM</a>
        </div>
        <!-- Tombol Login memanggil modal -->
        <button onclick="openModal()" 
            class="bg-black text-white px-4 py-2 rounded-full hover:bg-gray-800">
            LOGIN
        </button>
    </nav>

    <!-- Main Content -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 px-8 py-10 items-center">
        <!-- Left Content -->
        <div>
            <h1 class="text-4xl font-bold mb-4">SELAMAT DATANG DI<br>ABSENSI SISWA</h1>
            <p class="text-gray-500 mb-4">
                Selamat datang di Absensi Sekolahmu, tempat di mana setiap kedatangan adalah awal dari hari yang penuh semangat. Mari kita wujudkan kedisiplinan, kebersamaan, dan prestasi bersama, dimulai dari langkah sederhana: hadir tepat waktu.
            </p>
            <p class="font-semibold mb-2">Silahkan Absen</p>

            <!-- Form Absen -->
            <form action="" method="POST" class="flex items-center gap-2 mb-6">
                <input type="text" name="nis" placeholder="masukan NIS MU" autocomplete="on" autofocus 
                    class="border border-gray-300 rounded-full px-4 py-2 w-full focus:outline-none focus:ring-2 focus:ring-black">
                <button type="submit" class="bg-black text-white px-6 py-2 rounded-full hover:bg-gray-800">ABSEN</button>
            </form>

            <?php if (!empty($pesan)): ?>
            <div class="mt-2 text-sm <?php echo strpos($pesan, 'berhasil') !== false ? 'text-green-600' : 'text-red-600'; ?>">
                <?php echo $pesan; ?>
            </div>
            <?php endif; ?>
            <!-- Tabel Data  -->
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white border border-gray-200 rounded-lg overflow-hidden">
                    <thead class="bg-gray-100 border-b border-gray-200">
                        <tr>
                            <th class="px-4 py-3 text-left font-semibold uppercase tracking-wider">No</th>
                            <th class="px-4 py-3 text-left font-semibold uppercase tracking-wider">Nama</th>
                            <th class="px-4 py-3 text-left font-semibold uppercase tracking-wider">Kelas</th>
                            <th class="px-4 py-3 text-left font-semibold uppercase tracking-wider">Jam Absen</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        <?php if (empty($riwayat_absen)): ?>
                            <tr>
                                <td colspan="6" class="px-4 py-4 text-center text-sm text-gray-500">Tidak ada data absen</td>
                            </tr>
                        <?php else: ?>
                            <?php $no = 1; ?>
                            <?php foreach ($riwayat_absen as $absen): ?>
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="px-4 py-3 whitespace-nowrap text-sm "><?php echo $no++; ?></td>
                                    <td class="px-4 py-3 whitespace-nowrap text-sm font-medium uppercase">
                                        <?php echo htmlspecialchars($absen['nama']); ?>
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap text-sm">
                                        <?php echo htmlspecialchars($absen['kelas']); ?>
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap text-sm">
                                        <?php echo date('H:i:s', strtotime($absen['waktu'])); ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Right Content -->
        <div class="flex justify-right ml-6">
            <img src="./images/outer-bailey.jpg" 
                 alt="Gambar" 
                 class="rounded-2xl object-cover" 
                 style="width: 630px; height: 800px;">
        </div>
    </div>

    <!-- Login Modal -->
    <?php include 'login-popup.php'; ?>

    <script>
        function openModal() {
            document.getElementById('loginModal').classList.remove('hidden');
        }
        function closeModal() {
            document.getElementById('loginModal').classList.add('hidden');
        }
    </script>

</body>
</html>

