<?php
    include "koneksi.php";
    
    if(isset($_GET['id'])){
        $id = $_GET['id'];
        $sql = "SELECT foto FROM data_siswa WHERE id = '$id'";
        $query = mysqli_query($conn, $sql);
        $query_foto = mysqli_fetch_assoc($query);
        $foto = $query_foto['foto'];

        mysqli_begin_transaction($conn);
        try{
            $query_absensi = "DELETE FROM data_siswa WHERE id = '$id'";
            mysqli_query($conn, $query_absensi);
            if (!empty($foto)) {
                $path_foto = __DIR__ . '/images/' . $foto;
                
                if (file_exists($path_foto)) {
                    if (!unlink($path_foto)) {
                        throw new Exception("Gagal menghapus file foto");
                    }
                }
            }
            mysqli_commit($conn);
            $_SESSION['success'] = "Data siswa dan foto berhasil dihapus";
            echo "i";
        }catch (Exception $e) {
            // Jika ada error, rollback transaksi
            mysqli_rollback($conn);
            $_SESSION['error'] = $e->getMessage();
            echo "g";
        }

    header("location: data_siswa.php");
    exit();
}
?>