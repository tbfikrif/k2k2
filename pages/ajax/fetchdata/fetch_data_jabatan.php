   <?php  
     error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
      $output = '';  
      include "../../../con_db.php";

      $id_jabatan = $_POST['id_jabatan'];

      $query = "SELECT * FROM tb_jabatan WHERE id_jabatan = '$id_jabatan'";  
      $result = mysqli_query($koneksi, $query);  
      $output .= ' 
      <label><h4>   Anda yakin akan menghapus data ini?</h4></label>
      <br>
      <br>
           <table class="table table-hover table-responsive">';  
      while($row = mysqli_fetch_array($result)) 
      {  
         $gaji = number_format($row[gaji]);
           $output .= '
                <tbody>
                <tr>  
                     <td width="30%"><label>ID Jabatan</label></td>  
                     <td width="30%">'.$row["id_jabatan"].'</td> 
                </tr>
                <tr>     
                     <td width="40%"><label>Jabatan</label></td>  
                     <td width="40%">'.$row["jabatan"].'</td>  
                </tr>
                <tr>
                     <td width="30%"><label>Gaji</label></td> 
                     <td width="30%">Rp. '.$gaji.'</td>
                </tr>
                </tbody>
           ';  
      }  
      $output .= '  
           </table>   
      ';  
      session_start();
      $_SESSION["idhapus"] = $id_jabatan;
      echo $output;   
 ?>