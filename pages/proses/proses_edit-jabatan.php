 <?php  
include "../../con_db.php";
 error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));

      $id = $_POST["id_jabatan"];
      $jabatan = $_POST["jabatan"];  
      $nominal= $_POST['gaji'];
      $nominal1 = str_replace('.', '', $nominal);
      $gaji = str_replace('Rp ', '', $nominal1);

           $query = "UPDATE tb_jabatan SET jabatan='$jabatan', gaji='$gaji' WHERE id_jabatan='$id'";   
           
           $result =  mysqli_query($koneksi, $query);
           
           if (!$result) {
              printf("Error: %s\n", mysqli_error($koneksi));
              exit();
              } 
      echo '<script> alert("Data Jabatan dengan ID '.$id.', Berhasil Di Update"); window.location="../../tampil/data-jabatan"</script>';   
