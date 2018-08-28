<?php
    require_once('../con_db.php');
    
    $tanggal = date("Y-m-d");
    $sql = "SELECT count(id_anggota) as jumlah FROM tb_anggota WHERE status = 'Aktif'";

    $query = mysqli_query($koneksi, $sql);

    $data=mysqli_fetch_assoc($query);

    echo json_encode($data);
?>