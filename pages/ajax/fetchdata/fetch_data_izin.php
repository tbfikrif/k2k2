   <?php  
     error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));

      $output = '';  
      include "../../../con_db.php";

      $query = "SELECT tb_absen.id, tb_anggota.id_anggota, tb_anggota.nama, tb_absen.keterangan FROM tb_absen JOIN tb_anggota ON tb_absen.id_anggota = tb_anggota.id_anggota WHERE tb_absen.keterangan = 'izin'";  
      $result = mysqli_query($koneksi, $query);  
      $output .= '  
      <div class="table-responsive">  
           <table class="table table-bordered">';  
      while($row = mysqli_fetch_array($result))  
      {  
           $output .= ' 
           <br>
                <tr>  
                     <td width="50%"><label> ID Anggota </label></td>  
                     <td width="50%"><label> Nama </label></td>  
                </tr>   
                <tr>  
                     <td width="30%">'.$row["id_anggota"].'</td>  
                     <td width="70%">'.$row["nama"].'</td>  
                </tr>  
           ';  
      }  
      $output .= '  
           </table>  
      </div>  
      ';  
      echo $output;  

 ?>