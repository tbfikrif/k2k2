   <?php  
     error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
	  session_start();
      include "../../../con_db.php";
      $query = "SELECT COUNT(d.status_id) AS value,a.warna AS color,a.warna AS highlight,a.status AS label FROM tb_detail_absen d JOIN tb_absen a ON d.status_id = a.status_id GROUP BY d.status_id;";  
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