<?php  
 //fetch.php  
  include "../../../con_db.php";
  session_start();
  date_default_timezone_set('Asia/Jakarta');	
  $tgl_now = date("d-m-Y");
  $year = date('Y', strtotime($tgl_now));
  if (strpos($_SESSION['jabatan'], 'Admin')!==false) {
    $sql_grafik = sprintf("SELECT  SUBSTRING(MONTHNAME(`tanggal`),1,3) as Bulan, SUM(`nominal`) as Total FROM `tb_pembayaran` WHERE `status` = '2' AND YEAR(`tanggal`) = '$year' GROUP BY Bulan, MONTH(`tanggal`), YEAR(`tanggal`) ORDER BY Year(`tanggal`),month(`tanggal`)");
  } else {
    $sql_grafik = sprintf("SELECT SUBSTRING(MONTHNAME(`tanggal`),1,3) as Bulan, SUM(`nominal`) as Total FROM `tb_pembayaran` WHERE `id_anggota`='$_SESSION[id_anggota]' AND `status` = '2' AND YEAR(`tanggal`) = '$year' GROUP BY Bulan, MONTH(`tanggal`), YEAR(`tanggal`) ORDER BY Year(`tanggal`),month(`tanggal`)");  
  }
  $hasil4 = $koneksi->query($sql_grafik);
  if (!$hasil4) {
    printf("Error: %s\n", mysqli_error($koneksi));
    exit();
  }
  $all4=array();
  while($row4 = mysqli_fetch_array($hasil4)){
    $all4[]=$row4;
  }
  $data4 = json_encode($all4);
  echo  $data4;
?>