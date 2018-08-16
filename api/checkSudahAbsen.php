<?php
    require_once('../con_db.php');
    
    $id_anggota = $_REQUEST['id_anggota'];
    $tanggal = date("Y-m-d");
    $sql = "SELECT id_anggota FROM tb_detail_absen WHERE id_anggota = '$id_anggota' AND tanggal = '$tanggal'";

    $query = mysqli_query($koneksi, $sql);
    $count = mysqli_num_rows($query);
    if ($count == 0) {
        echo json_encode(array( 'response'=>'Belum Absen' ));
    } else {
        echo json_encode(array( 'response'=>'Sudah Absen' ));
    }
?>