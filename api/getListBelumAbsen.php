<?php
    require_once('../con_db.php');
    
    $tanggal = date("Y-m-d");
    $sql = "SELECT * FROM tb_anggota WHERE id_anggota NOT IN(SELECT tb_anggota.id_anggota FROM tb_detail_absen JOIN tb_anggota ON tb_detail_absen.id_anggota=tb_anggota.id_anggota WHERE tanggal = '$tanggal') AND status = 'Aktif'";

    $query = mysqli_query($koneksi, $sql);

    $response = array();
    while ($row = mysqli_fetch_array($query)) {
        array_push($response, array(
            'id_anggota' => $row['id_anggota'],
            'nama' => $row ['nama'],
            'jam_masuk' => 'Belum Masuk',
            'status_id' => '0',
            'email' => $row['email'],
            'foto' => $row['foto_profile']
        ));
    }

    echo json_encode($response);

    mysqli_close($koneksi);
?>