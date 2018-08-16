<?php
    require_once('../con_db.php');
    
    $tanggal = date("Y-m-d");
    $sql = "SELECT * FROM tb_detail_absen JOIN tb_anggota ON tb_detail_absen.id_anggota=tb_anggota.id_anggota WHERE tanggal = '$tanggal'";

    $query = mysqli_query($koneksi, $sql);

    $response = array();
    while ($row = mysqli_fetch_array($query)) {
        array_push($response, array(
            'id_anggota' => $row['id_anggota'],
            'nama' => $row ['nama'],
            'jam_masuk' => $row['jam_masuk'],
            'status_id' => $row['status_id'],
            'keterangan' => $row['keterangan'],
            'email' => $row['email'],
            'foto' => $row['foto_profile']
        ));
    }

    echo json_encode($response);

    mysqli_close($koneksi);
?>