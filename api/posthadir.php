<?php
    require_once('../con_db.php');
    
    $id_anggota = $_REQUEST['id_anggota'];
    $tanggal = date("Y-m-d");
    $jam_masuk = $_REQUEST['jam_masuk'];
    $status_hadir = 1;
    $sql = "INSERT INTO tb_detail_absen VALUES (NULL, '$id_anggota', '$tanggal', '$jam_masuk', NULL, $status_hadir, NULL, -6.8900925, 107.58005659999999, '$tanggal', '$tanggal', NULL, NULL, 50, 25000, 'unpaid')";

    $query = mysqli_query($koneksi, $sql);

    $error = $koneksi->error;

    if($query) {
	    echo json_encode(array( 'response'=>'success' ));
	} else {
	    echo json_encode(array( 'response'=>$error ));
    }
?>