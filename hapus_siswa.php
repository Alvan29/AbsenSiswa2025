<?php
    include "koneksi.php";
    
    if(isset($_GET['id'])){
        $id = $_GET['id'];
        $sql = "DELETE FROM data_siswa WHERE id=$id";
        $query = mysqli_query($conn, $sql);

        if ($query){
            header("location: data_siswa.php");
        }else{
            die("Gagal menghapus");
        }
    }else{
        die("Akses dilarang");
    }
?>