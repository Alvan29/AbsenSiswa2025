<?php
include "koneksi.php";
?>
<head>
    <meta charset="UTF-8">
    <script src="https://cdn.tailwindcss.com"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Check</title>
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

      document.getElementById('clock','JamAbs').textContent = jam;
      document.getElementById('tanggal').textContent = hari;
    }
    setInterval(updateClock, 1000);
    window.onload = updateClock;
  </script>
</head>
<body>
    <div class="bg-gray-200 min-h-screen flex items-center justify-center font-sans">
        <div class="flex flex-col md:flex-row items-center justify-center w-full max-w-screen-xl px-4 py-10 gap-14">
            <div class="w-64 h-64 rounded-xl overflow-hidden flex items-center justify-center">
                <img src="images-removebg-preview.png" alt="Logo Sekolah" class="w-full h-full object-contain">
            </div>

                <!-- Tengah -->
            <div class="text-center space-y-5">
            <h1 class="text-2xl font-semibold text-gray-800">Absensi Sekolah</h1>

            <div class="text-6xl font-bold text-gray-900" id="clock">00:00:00</div>
            <div class="text-lg text-gray-700" id="tanggal">Senin, 1 Januari 2025</div>
            <div class="text-lg text-black font-semibold" id="JamAbs">kamu absen Di jam :</div>
            <div class="text-lg text-black font-semibold">IP Kamu :</div>
            <div class="text-lg text-black font-semibold">device :</div>
            <div class="text-lg text-black font-semibold">browser :</div>
            </div>
        </div>
    </div>
</body>
</html>