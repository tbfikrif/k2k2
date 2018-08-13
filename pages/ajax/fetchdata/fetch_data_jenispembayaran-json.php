<?php  
 //fetch.php  
 include "../../../con_db.php";
 if(isset($_POST["id_jenis"]))  
 {  
      $query = "SELECT * FROM tb_jenistransaksi WHERE id_jenis = '".$_POST["id_jenis"]."'";  
      $result = mysqli_query($koneksi, $query);  
      $row = mysqli_fetch_array($result);  
      echo json_encode($row);  
 }  
 ?>