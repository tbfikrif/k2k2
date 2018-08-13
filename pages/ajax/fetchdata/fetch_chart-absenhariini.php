<?php  
 //fetch.php  
 //include "../../../con_db.php";
 $query = "SELECT COUNT(d.id_anggota) AS value,a.warna AS color,a.warna AS highlight,a.status AS label FROM tb_detail_absen d JOIN tb_absen a ON d.status_id = a.status_id WHERE DATE(d.tanggal)='$today' GROUP BY d.status_id;";
      $result = mysqli_query($koneksi, $query);  
      $all = array();
	   while($row = mysqli_fetch_assoc($result)) {
		    $all[] = $row;
    }
 $data =  json_encode($all);
 echo $data;
 ?>