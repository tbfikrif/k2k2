<?php  
 //fetch.php  
 include "../../../con_db.php";
 include "../../../fungsi_kakatu.php";
 if(isset($_POST["id_anggota"]))  
 {  
      $query = "SELECT a.id_anggota AS id_anggota,a.nama AS nama,a.email AS email, a.alamat AS alamat,a.tempat_lahir AS tempat_lahir,a.tgl_lahir AS tgl_lahir,a.jenis_kelamin AS jenis_kelamin,c.id_jabatan AS jabatan FROM tb_anggota a JOIN jabatan_anggota b ON a.id_anggota=b.id_anggota JOIN tb_jabatan c ON c.id_jabatan = b.id_jabatan WHERE a.id_anggota = '".$_POST["id_anggota"]."' GROUP BY id_anggota";  
      $result = mysqli_query($koneksi, $query);  
      $row = mysqli_fetch_array($result);
      //wq$row["password"]= decodeData($row["password"]); 
      session_start();
      $_SESSION["id_jabatan_sebelumnya_edit"]=$row["jabatan"];
      echo json_encode($row);  
 }  
 ?>