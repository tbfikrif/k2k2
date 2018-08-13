<?php  
 //fetch.php  
    include "../../../con_db.php"; 
    session_start();
    if (strpos($_SESSION['jabatan'], 'Admin')!==false) {
		$sql_grafik12 ="SELECT SUBSTRING(MONTHNAME(a.tanggal),1,3) AS Bulan,COUNT(CASE WHEN a.status_id = 1 OR a.status_id=2 THEN 1 ELSE NULL END) AS hadir,COUNT(CASE WHEN a.status_id = 3 THEN 1 ELSE NULL END) AS sakit,COUNT(CASE WHEN a.status_id = 4 THEN 1 ELSE NULL END) AS izin,COUNT(CASE WHEN a.status_id = 5 THEN 1 ELSE NULL END) AS cuti,COUNT(CASE WHEN a.status_id = 6 THEN 1 ELSE NULL END) AS alpha FROM tb_detail_absen a WHERE YEAR(a.tanggal) = YEAR(CURRENT_DATE()) GROUP BY MONTH(a.tanggal) ORDER BY YEAR(a.tanggal), MONTH(a.tanggal)";
	  } else {
		$sql_grafik12 = "SELECT SUBSTRING(MONTHNAME(a.tanggal),1,3)  AS Bulan,COUNT(CASE WHEN a.status_id = 1 OR a.status_id=2 THEN 1 ELSE NULL END) AS hadir,COUNT(CASE WHEN a.status_id = 3 THEN 1 ELSE NULL END) AS sakit,COUNT(CASE WHEN a.status_id = 4 THEN 1 ELSE NULL END) AS izin,COUNT(CASE WHEN a.status_id = 5 THEN 1 ELSE NULL END) AS cuti,COUNT(CASE WHEN a.status_id = 6 THEN 1 ELSE NULL END) AS alpha FROM tb_detail_absen a WHERE YEAR(a.tanggal) = YEAR(CURRENT_DATE()) AND a.id_anggota='$_SESSION[id_anggota]' GROUP BY MONTH(a.tanggal) ORDER BY YEAR(a.tanggal), MONTH(a.tanggal)";
	  }
      $hasil12 = $koneksi->query($sql_grafik12);
	  $error12='';
    if (!$hasil12) {
        $error12="Error: %s\n".mysqli_error($koneksi);
        exit();
    }

    $chart_data12 = '';
    //$all2[]=null;
    while($row12 = mysqli_fetch_array($hasil12))
    {
		  $all2[]=$row12;
	  }
    $data2 = json_encode($all2);
	  echo  $data2;
 ?>