   <?php  
     error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
     $id=$_POST["id"];
     if(isset($_POST['id'])){

      $output = '';  
      include "../../../con_db.php";

      $query = "SELECT * FROM tb_detail_absen WHERE id = '$id'";  
      $result = mysqli_query($koneksi, $query);  
      $output .= '  
      <div class="table-responsive">  
           <table class="table table-bordered">';  
      while($row = mysqli_fetch_array($result))  
      {  
           $output .= ' 
                <tr>  
                     <td width="30%"><label> Jam Submit </label></td>  
                     <td width="70%">'.$row["jam_masuk"].'</td>  
                </tr>   
                <tr>  
                     <td width="30%"><label> Keterangan </label></td>  
                     <td width="70%">'.$row["keterangan"].'</td>  
                </tr>
				<tr>  
                     <td width="30%"><label> Dari </label></td>  
                     <td width="70%">'.$row["tgl_awal"].'</td>  
                </tr>   
                <tr>  
                     <td width="30%"><label> Sampai </label></td>  
                     <td width="70%">'.$row["tgl_akhir"].'</td>  
                </tr>
				<tr>  
                     <td width="30%"><label> Sisa Cuti </label></td>  
                     <td width="70%">'.$row["cuti_used"].'</td>  
                </tr>
				<tr>  
                     <td width="30%"><label> Quota Cuti </label></td>  
                     <td width="70%">'.$row["cuti_qty"].'</td>  
                </tr>
                <tr>
                    <td width="30%"><label> Alamat </label></td>  
                    <td width="70%">'.$row["alamat_lokasi"].'</td> 
                </tr>
                <tr>
                    <td colspan="2" width="100%" id="peta" style="text-align: center;width:400px;height:400px;background:yellow"></td> 
                </tr>
           ';  
                session_start();
                $_SESSION['hapusid'] = $row["id"]; 
      }  
      $output .= '  
           </table>  
      </div>
      <script>
      function myMap() {
      var mapOptions = {
          center: new google.maps.LatLng(51.5, -0.12),
          zoom: 10,
          mapTypeId: google.maps.MapTypeId.HYBRID
      }
      var map = new google.maps.Map(document.getElementById("peta"), mapOptions);
      }
      </script>
      
      <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAn0sCC7HGqbJbWhwkgJnvyWFiTa7QGtVI&callback=myMap"></script>  
      ';  
      echo $output;  
    } 
 ?>