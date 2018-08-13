<?php  
 //fetch.php  
 include "../../../con_db.php";
 //if(isset($_POST["id_liburr"])){  
      $query = "SELECT id,nama_libur,DATE_FORMAT(tglawal, \"%m/%d/%Y\") AS tgl1 ,DATE_FORMAT(tglakhir, \"%m/%d/%Y\") AS tgl2 FROM tb_tgllibur WHERE id = '".$_POST["id_libur"]."'";  
      $result = mysqli_query($koneksi, $query);  
      $row = mysqli_fetch_array($result);
      echo json_encode($row);  
 //}  
 ?>