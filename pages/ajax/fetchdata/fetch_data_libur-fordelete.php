   <?php  
      error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
      $output = '';  
      include "../../../con_db.php";

      $id = $_POST['id'];

      $query = "SELECT * FROM tb_tgllibur WHERE id = '$id'";  
      $result = mysqli_query($koneksi, $query);  
      $output .= ' 
      <label><h4>   Anda yakin akan menghapus data ini?</h4></label>
      <br>
      <br>
           <table class="table table-hover table-responsive">';  
      while($row = mysqli_fetch_array($result)) 
      {  
           $output .= '
                <tbody>
                    <tr>  
                        <td width="30%"><label>ID</label></td>  
                        <td width="30%">'.$row["id"].'</td> 
                    </tr>
                    <tr>     
                        <td width="40%"><label>Nama Libur</label></td>  
                        <td width="40%">'.$row["nama_libur"].'</td>  
                    </tr>
                    <tr>     
                        <td width="40%"><label>Dari</label></td>  
                        <td width="40%">'.$row["tglawal"].'</td>  
                    </tr>
                    <tr>     
                        <td width="40%"><label>Sampai</label></td>  
                        <td width="40%">'.$row["tglakhir"].'</td>  
                    </tr>
                </tbody>
           ';  
      }  
      $output .= '  
           </table>   
      ';  
      //session_start();
      //$_SESSION["idlibur"] = $id;
      echo $output;   
 ?>