<?php  
     error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
      include "../../../con_db.php";
      session_start();
      $query = "SELECT d.id AS id,a.status AS title,d.tgl_awal AS start,d.tgl_awal+ interval 1 day AS end,a.warna AS backgroundColor,a.warna AS borderColor FROM tb_detail_absen d JOIN tb_absen a ON d.status_id = a.status_id JOIN tb_anggota g ON d.id_anggota=g.id_anggota WHERE d.id_anggota='$_SESSION[id_anggota]'";  
      $result = mysqli_query($koneksi, $query);  
      $all = array();
	   while($row = mysqli_fetch_assoc($result)) {
		    $all[] = $row;
    }
    /*$namatgl = new DateTime();
    $namatgl->setTimezone(new DateTimeZone('Asia/Jakarta'));
    $namabaru= $namatgl->format('Ym');
    $bulan= new DateTime("2017-07-28");
    $tes=$bulan->format('Ym');
    printf($tes);
    printf($namabaru);*/
      echo json_encode($all);
 ?>