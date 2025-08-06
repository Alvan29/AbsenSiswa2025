<?php
  include 'koneksi.php';
  session_start();

  if (!isset($_SESSION['username'])){
    header("location: index.php");
    exit();
  }
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Dashboard - Absensi Sekolah</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="flex bg-gray-200 min-h-screen">

  <!-- Sidebar -->
  <?php include 'sidebar.php'; ?>
  <?php include 'logout_modal.php'; ?>

  <!-- Konten Utama -->
  <main class="flex-1 p-6 overflow-y-auto">

    <!-- Judul & Tombol Absen -->
    <div class="flex justify-between items-center mb-6">
      <h1 class="text-2xl font-bold text-gray-800">Dashboard</h1>
      <a href="index.php" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded text-sm font-medium shadow">
        + Absen Siswa
      </a>
    </div>


    <!-- Statistik Siswa dan Kelas -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
      <div class="bg-white rounded-lg shadow p-4 relative">
        <div class="absolute -top-4 left-4 bg-gray-100 p-2 rounded shadow">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A3.001 3.001 0 017 15h10a3.001 3.001 0 011.879.804M15 11a3 3 0 100-6 3 3 0 000 6zm-6 0a3 3 0 100-6 3 3 0 000 6z" />
          </svg>
        </div>
        <h2 class="text-center font-medium text-gray-700">Jumlah Siswa</h2>
        <p class="text-center text-2xl font-bold mt-2 text-blue-600">300</p>
      </div>

      <div class="bg-white rounded-lg shadow p-4 relative">
        <div class="absolute -top-4 left-4 bg-gray-100 p-2 rounded shadow">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h4l3 8 4-16 3 8h4" />
          </svg>
        </div>
        <h2 class="text-center font-medium text-gray-700">Jumlah Kelas</h2>
        <p class="text-center text-2xl font-bold mt-2 text-green-600">30</p>
      </div>
    </div>

    <!-- Absensi Hari Ini -->
    <div class="bg-white rounded-lg shadow mb-6">
      <div class="bg-gray-100 text-center py-2 font-semibold border-b border-gray-300">
        Absensi Siswa Hari Ini <br>
        <span class="text-xs text-gray-500"><?= date('d-m-Y') ?></span>
      </div>
      <div class="grid grid-cols-2 md:grid-cols-4 text-center py-4">
        <div>
          <p class="text-sm text-gray-600">Hadir</p>
          <p class="text-2xl font-semibold text-blue-600">0</p>
        </div>
        <div>
          <p class="text-sm text-gray-600">Sakit</p>
          <p class="text-2xl font-semibold text-orange-500">0</p>
        </div>
        <div>
          <p class="text-sm text-gray-600">Izin</p>
          <p class="text-2xl font-semibold text-green-500">0</p>
        </div>
        <div>
          <p class="text-sm text-gray-600">Alfa</p>
          <p class="text-2xl font-semibold text-red-600">0</p>
        </div>
      </div>
    </div>

    <!-- Grafik Kehadiran -->
    <div class="bg-white rounded-lg shadow p-4">
      <canvas id="chartAbsensi" height="120"></canvas>
      <div class="mt-4">
        <h2 class="font-semibold text-sm text-gray-700">Tingkat kehadiran siswa</h2>
        <p class="text-xs text-gray-500">Jumlah kehadiran siswa dalam 10 hari terakhir</p>
      </div>
    </div>

  </main>

  <!-- Script Chart -->
  <script>
    const ctx = document.getElementById('chartAbsensi').getContext('2d');
    const chartAbsensi = new Chart(ctx, {
      type: 'line',
      data: {
        labels: Array.from({ length: 10 }, (_, i) => `Hari ${i + 1}`),
        datasets: [
          {
            label: 'Hadir',
            data: [100, 200, 150, 180, 90, 130, 170, 140, 160, 210],
            borderColor: 'rgba(59, 130, 246, 1)',
            backgroundColor: 'rgba(59, 130, 246, 0.1)',
            tension: 0.3,
            fill: true,
            pointRadius: 3
          },
          {
            label: 'Sakit',
            data: [50, 60, 40, 70, 20, 30, 60, 40, 70, 50],
            borderColor: 'rgba(234, 88, 12, 1)',
            backgroundColor: 'rgba(234, 88, 12, 0.1)',
            tension: 0.3,
            fill: true,
            pointRadius: 3
          },
          {
            label: 'Izin',
            data: [20, 30, 50, 40, 60, 20, 30, 40, 30, 25],
            borderColor: 'rgba(34, 197, 94, 1)',
            backgroundColor: 'rgba(34, 197, 94, 0.1)',
            tension: 0.3,
            fill: true,
            pointRadius: 3
          }
        ]
      },
      options: {
        responsive: true,
        plugins: {
          legend: { display: false }
        },
        scales: {
          x: {
            ticks: { display: true }
          },
          y: {
            beginAtZero: true,
            ticks: {
              stepSize: 50
            }
          }
        }
      }
    });
  </script>

</body>
</html>
