   <?php  
     error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
      $output = '';  
      include "../../../con_db.php";

      $id_anggota = $_POST['id_anggota'];

      $query = "SELECT * FROM tb_cuti_anggota WHERE id_anggota = '$id_anggota'";  
      $result = mysqli_query($koneksi, $query);  
      $output .= ' 
      <label><h4>   Anda yakin akan mereset data ini?</h4></label>
      <br>
      <br>
           <table class="table table-hover table-responsive">';  
      while($row = mysqli_fetch_array($result)) 
      {  
         $cuti_used = $row["cuti_used"];
		 $cuti_qty = $row["cuti_qty"];
           $output .= '
                <tbody>
                <tr>  
                     <td width="30%"><label>ID Anggota</label></td>  
                     <td width="30%">'.$row["id_anggota"].'</td> 
                </tr>
                <tr>     
                     <td width="40%"><label>Cuti Terpakai</label></td>  
                     <td width="40%">'.$row["cuti_used"].'</td>  
                </tr>
				<tr>     
                     <td width="40%"><label>Quota Cuti</label></td>  
                     <td width="40%">'.$row["cuti_qty"].'</td>  
                </tr>
                </tbody>
           ';  
      }  
      $output .= '  
           </table>   
      ';  
      session_start();
      $_SESSION["idcuti"] = $id_anggota;
      echo $output;   
 ?>