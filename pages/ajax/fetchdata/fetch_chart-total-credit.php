<?php  
 //fetch.php  
  include "../../../con_db.php";
  session_start();
  date_default_timezone_set('Asia/Jakarta');
  $today1 = date("Y-m-d");
  if (strpos($_SESSION['jabatan'], 'Admin')!==false) {
    $sql_grafik6 =sprintf("SELECT SUBSTRING(MONTHNAME(`tanggal`),1,3) AS Bulan,SUM(credit_in) AS Total FROM tb_detail_absen WHERE YEAR(tanggal) = YEAR('$today1') AND credit_stat='paid' GROUP BY Bulan, MONTH(tanggal), YEAR(tanggal) ORDER BY Year(tanggal),MONTH(tanggal)");
  //$sql_grafik6 = sprintf("SELECT SUBSTRING(MONTHNAME(`tanggal_set`),1,3) AS Bulan, SUM(`total_credit`) AS Total FROM `tb_credits_anggota` WHERE YEAR(`tanggal_set`) = '$year6' GROUP BY Bulan, MONTH(`tanggal_set`), YEAR(`tanggal_set`) ORDER BY Year(`tanggal_set`),MONTH(`tanggal_set`)");
  } else {
    $sql_grafik6 =sprintf("SELECT SUBSTRING(MONTHNAME(`tanggal`),1,3) AS Bulan,SUM(credit_in) AS Total FROM tb_detail_absen WHERE YEAR(tanggal) = YEAR('$today1') AND id_anggota='$_SESSION[id_anggota]' AND credit_stat='paid' GROUP BY Bulan, MONTH(tanggal), YEAR(tanggal) ORDER BY Year(tanggal),MONTH(tanggal)");
  }
  $hasil6 = $koneksi->query($sql_grafik6);
  if (!$hasil6) {
    echo "Error: %s\n".mysqli_error($koneksi);
    exit();
  }

  $all3 = array();
  while($row6 = mysqli_fetch_array($hasil6))
  {
    $all3[]=$row6;
  }
  $data3 = json_encode($all3);
  echo  $data3;
  //echo "tai";
 ?>