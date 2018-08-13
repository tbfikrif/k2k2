   <?php  
     error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
     $id=$_POST["id"];
     if(isset($_POST['id'])){

      $output = '';  
      include "../../../con_db.php";

      $query = "SELECT * FROM tb_buktipembayaran WHERE id = '$id'";  
      $result = mysqli_query($koneksi, $query);  
      $output .= '  
      <div class="table-responsive">  
           <table class="table table-bordered">';  
      while($row = mysqli_fetch_array($result))  
      {  
           $output .= ' 
           <label> <h4> Anda yakin akan menghapus Gambar dibawah ini? </h4> </label>
           <label> <h4> <b>Warning</b> : Anda tidak bisa lagi mengambil gambar yang sudah di hapus ! </h4></label>
           <br>
                <tr>  
                     <td width="30%"><label> '.$row["bukti"].' </label></td>  
                     <td width="70%"><img src="dist/fotobukti/'.$row["bukti"].'" width="300" height="300"/></td>  
                </tr>   
           ';  
                session_start();
                $_SESSION['hapusid'] = $row["id"]; 
      }  
      $output .= '  
           </table>  
      </div>  
      ';  
      echo $output;  
    } 
 ?>