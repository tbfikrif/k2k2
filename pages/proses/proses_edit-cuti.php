 <?php  
include "../../con_db.php";
 error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));

      $id = $_POST["id_anggota"];
      $quota = $_POST["cuti_quota"];;

           $query = "UPDATE tb_cuti_anggota SET cuti_qty='$quota' WHERE id_anggota='$id'";   
           
           $result =  mysqli_query($koneksi, $query);
           
           if (!$result) {
              printf("Error: %s\n", mysqli_error($koneksi));
              exit();
              } 
      echo '<script> alert("Data Quota cuto dengan ID '.$id.', Berhasil Di Update"); document.location.href="../../tampil/data-cuti" </script>';  
?>