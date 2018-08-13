   <?php  
     error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
     $id=$_POST["id_pembayaran"];
     if(isset($_POST['id_pembayaran'])){

      $output = '';  
      include "../../../con_db.php";

      $query = "SELECT tb_pembayaran.id_pembayaran,tb_anggota.nama, tb_pembayaran.tanggal, tb_jenistransaksi.jenis, tb_pembayaran.nominal, tb_pembayaran.status FROM `tb_pembayaran`JOIN `tb_anggota` ON tb_pembayaran.id_anggota = tb_anggota.id_anggota JOIN tb_jenistransaksi ON tb_pembayaran.id_jenis = tb_jenistransaksi.id_jenis  WHERE tb_pembayaran.id_pembayaran='$id' ORDER BY tb_pembayaran.tanggal DESC";  
      $result = mysqli_query($koneksi, $query);  
      $output .= '  
      <div class="table-responsive">  
           <table class="table table-bordered">';  
      while($row = mysqli_fetch_array($result))  
      {  

        $stat = '';
        if($row['status'] == "0"){
          $stat = "BELUM REIMBURSE";
        } else if ($row['status'] == "1"){
          $stat = "MENUNGGU KONFIRMASI";
        } else if($row['status'] == "2"){
          $stat = "SUDAH REIMBURSE";
        }

           $output .= '
            <label> <h4> Anda yakin akan menghapus data dibawah ini? </h4> </label>
            <br>
            <br> 
                <tr>  
                     <td width="30%"><label>ID Pembayaran</label></td>  
                     <td width="70%">'.$row["id_pembayaran"].'</td>  
                </tr>   
                <tr>  
                     <td width="30%"><label>Nama</label></td>  
                     <td width="70%">'.$row["nama"].'</td>  
                </tr>
                <tr>  
                     <td width="30%"><label>Jenis</label></td>  
                     <td width="70%">'.$row["jenis"].'</td>  
                </tr>    
                <tr>  
                     <td width="30%"><label>Tanggal Pembayaran</label></td>  
                     <td width="70%">'.$row["tanggal"].'</td>  
                </tr>  
                <tr>  
                     <td width="30%"><label>Nominal</label></td>  
                     <td width="70%">'.$row["nominal"].'</td>  
                </tr>  
                <tr>  
                     <td width="30%"><label>Status</label></td>  
                     <td width="70%">'.$stat.'</td>  
                </tr>  
           ';  
           session_start();
      $_SESSION['pembayaranid'] = $row["id_pembayaran"]; 
      }  
      $output .= '  
           </table>  
      </div>  
      ';  
      echo $output;  
       
    } 
 ?>