   <?php  
     error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
      $output = '';  
      include "../../../con_db.php";
      $id_jenis = $_POST['id_jenis'];
      $query = "SELECT * FROM tb_jenistransaksi WHERE id_jenis = '$id_jenis'";  
      $result = mysqli_query($koneksi, $query);  
      $output .= '  
      <label><h4>   Anda yakin akan menghapus data ini?</h4></label>
      <br>
      <br>
      <div class="table-responsive">  
           <table class="table table-bordered">';  
      while($row = mysqli_fetch_array($result))  
      {  
           $output .= ' 
                <tr>  
                     <td width="50%"><label>ID Jenis</label></td>  
                     <td width="50%">'.$row["id_jenis"].'</td>  
                     
                </tr>
                <tr>
                     <th width="50%"><label>Jenis Pembayaran</label></td>  
                     <td width="50%">'.$row["jenis"].'</td>  
                </tr>
           ';  
      }  
      $output .= '  
           </table>  
      </div>  
      ';  
      session_start();
      $_SESSION["idhapus"] = $id_jenis;
      echo $output;   
 ?>