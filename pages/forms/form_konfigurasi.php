
<?php 
  if (!defined('DIDALAM_INDEX_PHP')){ 
     //echo "Dilarang broh!";
     header("Location: ../../tampil/home");
  }
error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
?>

	<?php 
   		$tgl_now = date("d-m-Y"); 
		  $day = date('j', strtotime($tgl_now));
		  $month = date('F', strtotime($tgl_now));
		  $year = date('Y', strtotime($tgl_now));
		  $sql = "SELECT email_admin,pass_email,secret_key,secret_iv,api_key_google,latKantor,lngKantor,batas_ukuran_upload FROM tb_konfigurasi_kakatu ORDER BY tanggal_set DESC,jam_set DESC LIMIT 1";

		  $result=mysqli_query($koneksi,$sql);
			
		   if (!$result) {
              printf("Error: %s\n", mysqli_error($koneksi));
              exit();
              } 

	?>
				<div>
					<h2 style="float: right;"> <?php echo $day." - ".$month." - ".$year; ?> </h2>
					<hr>
					  <h2>KONFIGURASI KAKATU</h2> 
					  <hr style="border-color:#000000;">
					  <br>

					<?php
							while ($row=mysqli_fetch_array($result)) {	
					?>
					<section class="content-header" >
						<div class="container" style="width: 80%;"> 
							<form action="pages/proses/proses_edit-konfigurasi-kakatu.php" method="POST" enctype="multipart/form-data">   
							    <div class="form-group">
							      <label for="emailAdmin">Email Admin</label>
							      <input type="text" class="form-control" id="emailAdmin" placeholder="Email Admin" name="emailAdmin" value="<?php echo $row['email_admin']?>">
							    </div>

									<div class="form-group">
										<label for="passEmail">Pass Email Admin</label>
										<input type="password" class="form-control" id="passEmail" placeholder="Pass Email" name="passEmail" value="<?php echo $row['pass_email']?>" data-toggle="password">
									</div>

							    <div class="form-group">
										<label for="secretKey">Secret Key (Salt)</label>
										<input type="password" class="form-control" id="secretKey" placeholder="Secret Key" name="secretKey" value="<?php echo $row['secret_key']?>" data-toggle="password">
										<label><i style="color: #f39c12;">Mengubah Secret Key akan mereset semua password pegawai ke default!</i></label>
									</div>
									<div class="form-group">
										<label for="secretIV">Secret iv</label>
										<input type="password" class="form-control" id="secretIV" placeholder="Secret iv" name="secretIV" value="<?php echo $row['secret_iv']?>" data-toggle="password" >
										<label><i style="color: #f39c12;">Mengubah Secret IV akan mereset semua password pegawai ke default!</i></label>
									</div>
									<div class="form-group">
										<label for="apiGoogleKey">API Key Google Map</label>
										<input type="password" class="form-control" id="apiGoogleKey" placeholder="API Key Google Map" name="apiGoogleKey" value="<?php echo $row['api_key_google']?>" data-toggle="password">
									</div>
									<div class="form-group">
										<label for="latKantor">Latitude Kantor</label>
										<input type="password" class="form-control" id="latKantor" placeholder="Latitude Kantor" name="latKantor" value="<?php echo $row['latKantor']?>" data-toggle="password">
									</div>
									<div class="form-group">
										<label for="password">Longitude Kantor</label>
										<input type="password" class="form-control" id="lngKantor" placeholder="Longitude Kantor" name="lngKantor" value="<?php echo $row['lngKantor']?>" data-toggle="password">
									</div>
							    <div class="form-group">
							      <label for="ukuranUpload"> Batas Ukuran Upload </label>
							      <input class="form-control" type="text" id="ukuranUpload" name="ukuranUpload" data-validation="required" placeholder="Batas Ukuran upload" value="<?php echo $row['batas_ukuran_upload']?>">
							    </div>
									<input type="submit" name="submit" value="SIMPAN PERUBAHAN" class="btn btn-success pull-right">
							<?php } ?>
					</div>
				  </div>			  		
				  </form>
						<!--Close Form Group -->
					</section>  			 