   <?php  
     error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
      $output = '';  
      include "../../../con_db.php";

      $id = $_POST['id'];

      $query = "SELECT * FROM tb_credits_anggota WHERE id = '$id'";  
      $result = mysqli_query($koneksi, $query);  
      $output .= ' 
      <label><h4>   Anda yakin akan menghapus data ini?</h4></label>
      <br>
      <br>
           <table class="table table-hover table-responsive">';  
      while($row = mysqli_fetch_array($result)) 
      {  
         $total_credit = number_format($row[total_credit]);
           $output .= '
                <tbody>
                <tr>  
                     <td width="30%"><label>ID Anggota</label></td>  
                     <td width="30%">'.$row["id"].'</td> 
                </tr>
				        <tr>     
                     <td width="40%"><label>Jumlah Akomodasi</label></td>  
                     <td width="40%">'.$row["topup_credit"].'</td>  
                </tr>
                <tr>     
                      <td width="40%"><label>Jumlah Akomodasi</label></td>  
                      <td width="40%">'.$row["status"].'</td>  
                </tr>
                <tr>     
                      <td width="40%"><label>Jumlah Akomodasi</label></td>  
                      <td width="40%">'.$row["tanggal_set"].'</td>  
                </tr>
                <tr>     
                     <td width="40%"><label>Total Akomodasi</label></td>  
                     <td width="40%">'.$row["total_credit"].'</td>  
                </tr>
                </tbody>
           ';  
      }  
      $output .= '  
           </table>   
      ';  
      session_start();
      $_SESSION["idcredit"] = $id;
      echo $output;   
 ?>