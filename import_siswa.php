<?php
include 'koneksi.php';
session_start();

if (!isset($_SESSION['username'])) {
    header("location: index.php");
    exit();
}

$error = '';
$success = '';

// Proses upload file
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['import'])) {
    $kelas = mysqli_real_escape_string($conn, $_POST['kelas']);
    
    if (empty($kelas)) {
        $error = "Silakan pilih kelas terlebih dahulu";
    } elseif (!isset($_FILES['file']['name']) || $_FILES['file']['error'] != UPLOAD_ERR_OK) {
        $error = "Silakan pilih file Excel yang valid";
    } else {
        $file_ext = strtolower(pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION));
        
        if ($file_ext != 'xls' && $file_ext != 'xlsx') {
            $error = "Hanya file Excel (.xls, .xlsx) yang diperbolehkan";
        } else {
            require 'vendor/autoload.php'; // Pastikan PhpSpreadsheet terinstall
            
            $upload_dir = __DIR__ . '/uploads/';
            if (!file_exists($upload_dir)) {
                mkdir($upload_dir, 0755, true);
            }
            
            $file_name = uniqid() . '.' . $file_ext;
            $file_path = $upload_dir . $file_name;
            
            if (move_uploaded_file($_FILES['file']['tmp_name'], $file_path)) {
                try {
                    $reader = ($file_ext == 'xlsx') 
                        ? new \PhpOffice\PhpSpreadsheet\Reader\Xlsx() 
                        : new \PhpOffice\PhpSpreadsheet\Reader\Xls();
                    
                    $spreadsheet = $reader->load($file_path);
                    $worksheet = $spreadsheet->getActiveSheet();
                    $rows = $worksheet->toArray();
                    
                    mysqli_begin_transaction($conn);
                    $imported = 0;
                    $skipped = 0;
                    
                    foreach ($rows as $index => $row) {
                        // Skip header (baris pertama)
                        if ($index == 0) continue;
                        
                        // Validasi data minimal
                        if (empty($row[0])) continue; // Skip jika NIS kosong
                        
                        $nis = mysqli_real_escape_string($conn, $row[0]);
                        $nama = mysqli_real_escape_string($conn, $row[1] ?? '');
                        
                        // Cek duplikasi NIS
                        $check = mysqli_query($conn, "SELECT nis FROM data_siswa WHERE nis = '$nis'");
                        if (mysqli_num_rows($check)) {
                            $skipped++;
                            continue;
                        }
                        
                        // Insert data
                        $query = "INSERT INTO data_siswa (nis, nama, kelas) VALUES (?, ?, ?)";
                        $stmt = mysqli_prepare($conn, $query);
                        mysqli_stmt_bind_param($stmt, "sss", $nis, $nama, $kelas);
                        
                        if (mysqli_stmt_execute($stmt)) {
                            $imported++;
                        }
                        
                        mysqli_stmt_close($stmt);
                    }
                    
                    mysqli_commit($conn);
                    $success = "Berhasil mengimport $imported data siswa. ($skipped data duplikat dilewati)";
                    unlink($file_path); // Hapus file setelah diproses
                    
                } catch (Exception $e) {
                    mysqli_rollback($conn);
                    $error = "Error mengimport data: " . $e->getMessage();
                    if (file_exists($file_path)) unlink($file_path);
                }
            } else {
                $error = "Gagal mengupload file";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Import Data Siswa</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="flex bg-gray-100">
    <?php include 'sidebar.php'; ?>
    <?php include 'logout_modal.php'; ?>
    <div class="container mx-auto p-4">
        
        <div class="bg-white rounded-lg shadow p-6 max-w-2xl mx-auto">
            <h1 class="text-2xl font-bold mb-6">Import Data Siswa dari Excel</h1>
            
            <?php if ($error): ?>
                <div class="bg-red-100 text-red-700 p-3 mb-4 rounded"><?= $error ?></div>
            <?php endif; ?>
            
            <?php if ($success): ?>
                <div class="bg-green-100 text-green-700 p-3 mb-4 rounded"><?= $success ?></div>
            <?php endif; ?>
            
            <form method="POST" enctype="multipart/form-data" class="space-y-4">
                <div>
                    <label for="kelas" class="block text-sm font-medium text-gray-700 mb-1">Kelas</label>
                    <select id="kelas" name="kelas" required
                            class="w-full px-3 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-400">
                        <option value="">-- Pilih Kelas --</option>
                        <?php
                        $kelas_options = mysqli_query($conn, "SELECT DISTINCT kelas FROM data_siswa ORDER BY kelas");
                        while ($row = mysqli_fetch_assoc($kelas_options)) {
                            echo '<option value="'.htmlspecialchars($row['kelas']).'">'.htmlspecialchars($row['kelas']).'</option>';
                        }
                        ?>
                    </select>
                </div>
                
                <div>
                    <label for="file" class="block text-sm font-medium text-gray-700 mb-1">File Excel</label>
                    <input type="file" id="file" name="file" accept=".xls,.xlsx" required
                           class="w-full px-3 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-400">
                    <p class="text-xs text-gray-500 mt-1">Format file: .xls atau .xlsx (Kolom 1: NIS, Kolom 2: Nama)</p>
                </div>
                
                <div class="flex justify-between pt-4">
                    <a href="data_siswa.php" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded">Kembali</a>
                    <button type="submit" name="import" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">
                        Import Data
                    </button>
                </div>
            </form>
            
            <div class="mt-8 bg-blue-50 p-4 rounded">
                <h2 class="font-semibold text-blue-800 mb-2">Petunjuk:</h2>
                <ol class="list-decimal list-inside text-sm text-blue-700 space-y-1">
                    <li>Download template Excel <a href="TemplateData.xls" class="text-blue-600 underline">disini</a></li>
                    <li>Isi data siswa sesuai format (Kolom A: NIS, Kolom B: Nama)</li>
                    <li>Pilih kelas tujuan untuk data siswa</li>
                    <li>Upload file Excel yang sudah diisi</li>
                    <li>Data yang sudah ada (NIS duplikat) akan dilewati</li>
                </ol>
            </div>
        </div>
    </div>
</body>
</html>