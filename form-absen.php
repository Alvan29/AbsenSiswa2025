<?php
include "koneksi.php";
?>

<h2 class="text-2xl font-bold mb-4">Form Absen</h2>
<form action="index.php" method="post" class="space-y-4">
    <div>
        <label class="block mb-1 font-medium">NIS / ID Siswa</label>
        <input type="text" name="nis" required autofocus class="w-full border rounded-lg px-3 py-2">
    </div>
    <button type="submit" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg w-full">
        Simpan Absen
    </button>
</form>
