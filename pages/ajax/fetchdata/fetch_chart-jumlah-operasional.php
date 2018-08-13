<?php
  include "../../../con_db.php";
  session_start();
  date_default_timezone_set('Asia/Jakarta');
  $tgl_now = date("d-m-Y"); 
  $month = date('F', strtotime($tgl_now));
  if (strpos($_SESSION['jabatan'], 'Admin')!==false) {
	$sql_grafik_jenis = "SELECT tb_jenistransaksi.jenis, COUNT(tb_pembayaran.id_jenis) as 'jumlah' FROM tb_pembayaran JOIN tb_jenistransaksi ON tb_pembayaran.id_jenis=tb_jenistransaksi.id_jenis WHERE MONTHNAME(tb_pembayaran.tanggal) = '$month' GROUP BY tb_pembayaran.id_jenis";
  } else{
	$sql_grafik_jenis = "SELECT tb_jenistransaksi.jenis, COUNT(tb_pembayaran.id_jenis) as 'jumlah' FROM tb_pembayaran JOIN tb_jenistransaksi ON tb_pembayaran.id_jenis=tb_jenistransaksi.id_jenis WHERE id_anggota='$_SESSION[id_anggota]' AND MONTHNAME(tb_pembayaran.tanggal) = '$month' GROUP BY tb_pembayaran.id_jenis";  
  }
        $res_donut = mysqli_query($koneksi, $sql_grafik_jenis);

        $data = array();

  while($row = mysqli_fetch_array($res_donut))
  {
    $data[] = array(
      'value'  => $row['jumlah'],
      'label'  => $row['jenis']
    );
  }
  echo json_encode($data);
?>