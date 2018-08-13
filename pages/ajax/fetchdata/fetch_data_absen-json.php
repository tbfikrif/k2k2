<?php  
 //fetch.php  
 include "../../../con_db.php";
 if(isset($_POST["id"]))  
 {  
      $id= $_POST["id"];
      $query = "SELECT id,id_anggota,status_id,keterangan,DATE_FORMAT(tgl_awal, \"%m/%d/%Y\") AS tglawal ,DATE_FORMAT(tgl_akhir, \"%m/%d/%Y\") AS tglakhir FROM tb_detail_absen WHERE id ='$id'";
      
      $result = mysqli_query($koneksi, $query);  
      $row = mysqli_fetch_array($result);
      session_start();
      $_SESSION["status_id_absenAdminEdit"]=$row["status_id"];
      echo json_encode($row);
 }  
 ?>