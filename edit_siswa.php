<?php
include "koneksi.php";

$id = $_GET['id'] ?? 0;

$result = mysqli_query($conn, "SELECT * FROM data_siswa WHERE id='$id'");
$siswa = mysqli_fetch_assoc($result);

if (!$siswa) {
    die("Data siswa tidak ditemukan.");
}

if (isset($_POST['update'])) {
    $nis   = $_POST['nis'];
    $nama  = $_POST['nama'];
    $kelas = $_POST['kelas'];
    
    // Foto baru (opsional)
    $fotoBaru = $siswa['foto'];
    if (!empty($_FILES['foto']['name'])) {
        $targetDir = "uploads/";
        $fotoBaru = basename($_FILES["foto"]["name"]);
        move_uploaded_file($_FILES["foto"]["tmp_name"], $targetDir . $fotoBaru);
    }

    $update = mysqli_query($conn, "UPDATE data_siswa SET 
        nis='$nis', 
        nama='$nama', 
        kelas='$kelas', 
        foto='$fotoBaru' 
        WHERE id='$id'");

    if ($update) {
        header("Location: data_siswa.php");
        exit;
    } else {
        echo "Gagal mengupdate data: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Data Siswa</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">
    <div class="max-w-xl mx-auto mt-10 bg-white p-6 rounded-lg shadow">
        <h1 class="text-2xl font-bold mb-4">Edit Data Siswa</h1>
        <form method="post" enctype="multipart/form-data" class="space-y-4">
            <div>
                <label class="block font-medium">NIS</label>
                <input type="text" name="nis" value="<?= htmlspecialchars($siswa['nis']); ?>" 
                       class="w-full border rounded px-3 py-2" required>
            </div>
            <div>
                <label class="block font-medium">Nama</label>
                <input type="text" name="nama" value="<?= htmlspecialchars($siswa['nama']); ?>" 
                       class="w-full border rounded px-3 py-2" required>
            </div>
            <div>
                <label class="block font-medium">Kelas</label>
                <input type="text" name="kelas" value="<?= htmlspecialchars($siswa['kelas']); ?>" 
                       class="w-full border rounded px-3 py-2" required>
            </div>
            <div>
                <label class="block font-medium">Foto</label>
                <img src="uploads/<?= htmlspecialchars($siswa['foto']); ?>" alt="Foto Siswa" 
                     class="h-20 w-20 object-cover rounded mb-2 border">
                <input type="file" name="foto" class="w-full border rounded px-3 py-2">
            </div>
            <div class="flex justify-between">
                <a href="data_siswa.php" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">Batal</a>
                <button type="submit" name="update" 
                        class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</body>
</html>
