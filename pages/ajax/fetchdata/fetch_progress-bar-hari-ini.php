<?php  
 //fetch.php  
    include "../../../con_db.php";
    date_default_timezone_set('Asia/Jakarta');
    $today1 = date("Y-m-d");
    $selectAbsen="SELECT COUNT(id_anggota) AS jumabsen,(SELECT COUNT(id_anggota) FROM (SELECT a.id_anggota,a.nama FROM tb_anggota a JOIN jabatan_anggota b ON a.id_anggota = b.id_anggota JOIN tb_jabatan c ON c.id_jabatan = b.id_jabatan GROUP BY a.id_anggota HAVING GROUP_CONCAT(c.jabatan SEPARATOR ', ') NOT LIKE '%Admin%') AS Anggota) AS jumanggota FROM tb_detail_absen WHERE DATE(tanggal)='$today1'";
    $resAbsen = mysqli_query($koneksi, $selectAbsen);
    $rowAbsen= mysqli_fetch_assoc($resAbsen);
    $persen= ($rowAbsen['jumabsen']/$rowAbsen['jumanggota'])*100;
    $warna="";
    if($persen>=0 && $persen<=20){
        $warna="progress-bar-danger";
    } else if($persen>20 && $persen<=40) {
        $warna="progress-bar-warning";
    } else if($persen>40 && $persen<=60) {
        $warna="progress-bar-primary";
    } else if($persen>60 && $persen<=80) {
        $warna="progress-bar-info";
    } else if($persen>80 && $persen<=100) {
        $warna="progress-bar-success";
    }
    $data_progress = array();
    $data_progress['persen']= $persen;
    $data_progress['warna']= $warna;
    echo $json_progress=json_encode($data_progress);
?>