   <?php  
      error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
      include "../../../con_db.php";
      $query = "SELECT id AS id,nama_libur AS title, tglawal AS start,tglakhir + interval 1 day AS end, '#f56954' AS backgroundColor,'#f56954' AS borderColor FROM tb_tgllibur";  
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