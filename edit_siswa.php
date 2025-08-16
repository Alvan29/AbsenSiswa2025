<?php
include "koneksi.php";

// Ambil data siswa untuk diedit
$id = $_GET['id'];
$result = mysqli_query($conn, "SELECT * FROM data_siswa WHERE id='$id'");
$data = mysqli_fetch_assoc($result);

// Update data jika form disubmit
if (isset($_POST['update'])) {
    $nis = $_POST['nis'];
    $nama = $_POST['nama'];
    $id_kelas = $_POST['id_kelas'];

    // Cek apakah ada foto baru diupload
    if (!empty($_FILES['foto']['name'])) {
        $fotoBaru = basename($_FILES['foto']['name']);
        $targetDir = "images/"; // samakan dengan data_siswa.php
        $targetFile = $targetDir . $fotoBaru;

        // Pindahkan file ke folder images
        if (move_uploaded_file($_FILES['foto']['tmp_name'], $targetFile)) {
            // Hapus foto lama jika ada
            if (!empty($data['foto']) && file_exists("images/" . $data['foto'])) {
                unlink("images/" . $data['foto']);
            }
        } else {
            echo "Gagal upload foto!";
            exit;
        }
    } else {
        $fotoBaru = $data['foto']; // pakai foto lama jika tidak upload baru
    }

    // Query update data siswa (hanya sekali)
    $update = mysqli_query($conn, "
        UPDATE data_siswa SET 
            nis='$nis', 
            nama='$nama', 
            id_kelas='$id_kelas', 
            foto='$fotoBaru' 
        WHERE id='$id'
    ");

    if ($update) {
        header("Location: data_siswa.php");
        exit;
    } else {
        echo "Update data gagal: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Data Siswa</title>
    <link href="css/output.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center">
    <div class="bg-white shadow-lg rounded-lg p-6 w-full max-w-md">
        <h2 class="text-2xl font-bold mb-6 text-center text-gray-800">Edit Data Siswa</h2>
        <form method="POST" enctype="multipart/form-data" class="space-y-4">
            
            <div>
                <label class="block text-gray-700 mb-1">NIS</label>
                <input type="text" 
                       name="nis" 
                       value="<?php echo htmlspecialchars($data['nis']); ?>" 
                       required 
                       class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-400">
            </div>

            <div>
                <label class="block text-gray-700 mb-1">Nama</label>
                <input type="text" 
                       name="nama" 
                       value="<?php echo htmlspecialchars($data['nama']); ?>" 
                       required 
                       class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-400">
            </div>

            <div>
                <label class="block text-gray-700 mb-1">Kelas</label>
                <select name="id_kelas" 
                        required 
                        class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-400">
                    <option value="">-- Pilih Kelas --</option>
                    <?php
                    $kelasResult = mysqli_query($conn, "SELECT * FROM kelas");
                    while ($k = mysqli_fetch_assoc($kelasResult)) {
                        $selected = ($k['Id'] == $data['id_kelas']) ? "selected" : "";
                        echo "<option value='{$k['Id']}' $selected>{$k['nama_kelas']}</option>";
                    }
                    ?>
                </select>
            </div>

            <div>
                <label class="block text-gray-700 mb-1">Foto</label>
                <input type="file" 
                       name="foto" 
                       class="w-full text-gray-700">
                <?php if (!empty($data['foto'])) { ?>
                    <div class="mt-2">
                        <img src="images/<?php echo htmlspecialchars($data['foto']); ?>" 
                             alt="Foto Siswa" 
                             class="w-24 h-24 object-cover rounded border border-gray-300">
                    </div>
                <?php } ?>
            </div>

            <div class="flex justify-end space-x-2 mt-6">
                <a href="data_siswa.php" 
                   class="px-4 py-2 bg-gray-400 text-white rounded hover:bg-gray-500 transition">
                   Batal
                </a>
                <button type="submit" 
                        name="update" 
                        class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">
                        Update
                </button>
            </div>
        </form>
    </div>
</body>
</html>
