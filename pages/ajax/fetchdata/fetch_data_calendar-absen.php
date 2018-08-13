<?php  
     error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
	  //session_start();
      include "../../../con_db.php";
      $query = "SELECT d.id AS id,CONCAT(g.nama,' ',a.status) AS title,CONCAT(d.tgl_awal,'T',d.jam_masuk) AS start,CONCAT(d.tgl_akhir+ interval 1 day,'T','17:00:00') AS end,a.warna AS backgroundColor,a.warna AS borderColor FROM tb_detail_absen d JOIN tb_absen a ON d.status_id = a.status_id JOIN tb_anggota g ON d.id_anggota=g.id_anggota";  
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