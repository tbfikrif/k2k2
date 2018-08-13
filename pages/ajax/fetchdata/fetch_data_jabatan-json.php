<?php  
 //fetch.php  
 include "../../../con_db.php";
 if(isset($_POST["id_jabatan"]))  
 {  
      $query = "SELECT * FROM tb_jabatan WHERE id_jabatan = '".$_POST["id_jabatan"]."'";  
      $result = mysqli_query($koneksi, $query);  
      $row = mysqli_fetch_array($result);  
      echo json_encode($row);  
 }  
 ?>