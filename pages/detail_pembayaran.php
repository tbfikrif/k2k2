<?php
if (!defined('DIDALAM_INDEX_PHP')){ 
     //echo "Dilarang broh!";
     header("Location: ../home");
     exit();
  } else {
?>
<!DOCTYPE html>
<html lang='en'>
<?php 
error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
?>
	<head>
	  <!-- Tell the browser to be responsive to screen width -->
	  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	  <!-- Google Font -->
		  <!-- jQuery 3 -->
		<script type="text/javascript" src="bower_components/bootbox/bootbox.min.js"></script>
	  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
	</head>
	<?php 
		  include "../con_db.php";
		  session_start();
		  date_default_timezone_set("Asia/Jakarta");
   		  $tgl_now = date("d-m-Y"); 
		  $day = date('j', strtotime($tgl_now));
		  $month = date('F', strtotime($tgl_now));
		  $year = date('Y', strtotime($tgl_now));


		  $id_pembayaran = mysqli_real_escape_string($koneksi, $_GET['id']);
		  $_SESSION['id_pembayaran'] = $id_pembayaran;

		  $sql = "SELECT tb_pembayaran.id_pembayaran, tb_anggota.id_anggota, tb_anggota.nama, tb_pembayaran.tanggal, tb_jenistransaksi.id_jenis, tb_jenistransaksi.jenis, tb_pembayaran.nominal, tb_pembayaran.keterangan, tb_pembayaran.status FROM `tb_pembayaran`JOIN `tb_anggota` ON tb_pembayaran.id_anggota = tb_anggota.id_anggota JOIN tb_jenistransaksi ON tb_pembayaran.id_jenis = tb_jenistransaksi.id_jenis WHERE tb_pembayaran.id_pembayaran='$id_pembayaran'";

		  $result=mysqli_query($koneksi,$sql);

		   if (!$result) {
              printf("Error: %s\n", mysqli_error($koneksi));
              exit();
              } 

          $sql_bukti = "SELECT * FROM tb_buktipembayaran WHERE id_pembayaran = '$id_pembayaran'";
          $result_bukti = mysqli_query($koneksi, $sql_bukti);   

	?>
		<body>
				<div>
					<h2 class="pull-right"> <?php echo $day." - ".$month." - ".$year; ?> </h2>
					<hr>
					<br>
					  <h2>FORM PEMBAYARAN</h2> 
					  <hr style="border-color:#3c8dbc;">
					  <br>
					  <div class="form-group">
					  <label for="nominal"> Bukti Pembayaran </label>
					  <br>
					  <br>
					  <table>
					  	<tr>
					  <?php 
					  	while ($r = mysqli_fetch_array($result_bukti)){
					  		$path = $r[bukti];
					  		?>
					  	 	
					    <td style="padding: 5px;"> 
					      <a class='popupimage' href='<?php echo "dist/fotobukti/".$path; ?>' data-target="#myModal_img">
					      	<img <?php echo "src='dist/fotobukti/".$path."'"; ?> class="img-responsive" width="260" height="60">
					      </a>
					      </td>
					  		
					    </div>
						<!--Close Form Group -->
						   <?php
					  	}
					  ?>

					    <div class="modal fade" id="myModal_img" role="dialog">
						    <div class="modal-dialog">
						  	    <div class="modal-content">

								        <img src='' class="img-responsive" style="width: 100%;" />							    
								</div>
						      </div>
						</div>

					  <script>
					  	
					  		$(document).ready(function(){
					  			$('.popupimage').click(function(event){
					  				event.preventDefault();
					  				$('#myModal_img img').attr('src', $(this).attr('href'));
					  				$('#myModal_img').modal('show');
					  			});
					  		});
					  </script>
					    <?php
							while ($row=mysqli_fetch_array($result)) {	
								$jml_uang = number_format($row['nominal']);
								$tgl_new_format = date("d-m-Y", strtotime($row['tanggal']));
								$dayname = date('l', strtotime($row['tanggal']));

								  if($dayname =="Monday"){
							      	$hari = "Senin";
							      } else if($dayname == "Tuesday"){
							      	$hari = "Selasa";
							      } else if ($dayname == "Wednesday"){
							      	$hari = "Rabu";
							      } else if ($dayname == "Thursday"){
							      	$hari = "Kamis";
							      } else if ($dayname == "Friday"){
							      	$hari = "Jumat";
							      } else if($dayname == "Saturday"){
							      	$hari = "Sabtu";
							      } else if($dayname == "Sunday"){
							      	$hari = "Minggu";
							      }
    							
						?>
						</tr>
					</table>	
					    <hr style="border-color: #3c8dbc;">
					<section class="content-header" >
						<div class="container" style="width: 80%;">    
					    <div class="form-group">
					      <label for="id_pembayaran">ID Pembayaran</label>
					      <input type="text" class="form-control" id="id_pembayaran" placeholder="Id Pembayaran" name="id_pembayaran" value="<?php echo $row['id_pembayaran']; ?>" readonly>
					    </div>

					    <div class="form-group">
					      <label for="Id_anggota">ID Anggota</label>
					      <input type="text" class="form-control" id="id_anggota" name="id_anggota" value="<?php echo $row['id_anggota'];?>" readonly >
					    </div>

					    <div class="form-group">
					      <label for="Id_anggota">Jenis Pembayaran</label>
					      <input type="text" class="form-control" id="id_anggota" name="<?php echo $row['id_jenis']?>" value="<?php echo $row['jenis'];?>" readonly>
					    </div>

					    <div class="form-group">
					      <label for="nominal"> Nominal </label>
					      <input class="form-control" type="text" id="nominal" name="nominal" value="<?php echo 'Rp. '.$jml_uang ?>" readonly>
					    </div>

					    <div class="form-group">
					      <label for="keterangan"> Keterangan </label>
					      <textarea class="form-control" rows="5" id="keterangan" name="keterangan" placeholder="Keterangan Pembayaran" readonly> <?php echo $row['keterangan']; ?> </textarea>
					    </div>
				
					    <?php  list($one, $two) = explode(",", $_SESSION['jabatan'] , 2); ?>

					    <!-- Trigger the modal with a button -->
						  <Button type="button" class="btn btn-primary btn-sm" id="btnkonfirm" data-toggle="modal" data-target="#myModal_pesan">KONFIRMASI</Button>
						   <a href="tampil/form-edit-pembayaran/<?php echo $id_pembayaran?>/<?php echo $row['id_jenis']?>" class="btn btn-warning btn-sm" id="editbtn">EDIT</a>
						         <?php
						     if($one == 'Admin'){
						     	if($row[status] == "1"){
							          			?>
							          			<a style="margin-right: 1px;" href="whatsapp://send?text=Uang <?php echo $row['jenis'] ?> dengan ID Pembayaran <?php echo $row['id_pembayaran']?> , pada hari <?php echo $hari.", ".$tgl_new_format?>. Sebesar Rp.<?php echo number_format($row['nominal'])?>. Sudah saya terima
								      				        
								        		" class="btn btn-success btn-sm pull-right" id="whatsappadmin" data-action="share/whatsapp/share">SHARE<i class="fa fa-whatsapp"></i></a>
							          			<?php
							          		}
							          		?>
							          	<a style="margin-right: 1px;" href="whatsapp://send?text=Uang <?php echo $row['jenis']?> dengan ID Pembayaran <?php echo $row['id_pembayaran']?>, pada hari <?php echo $hari.", ".$tgl_new_format?>. Sebesar Rp.<?php echo number_format($row['nominal'])?> sudah di Transfer ke Rekening Bank Anda, silahkan di cek.
								        
								        	" class="btn btn-success btn-sm pull-right" data-action="share/whatsapp/share" id="whatsappcek">SHARE<i class="fa fa-whatsapp"></i></a>
							          		<?php
							  
							          	} else if($one != 'Admin'){
							          		if($row[status] == "2"){
							          			?>
							          			<a style="margin-right: 1px;" href="whatsapp://send?text=Uang <?php echo $row['jenis'] ?> dengan ID Pembayaran <?php echo $row['id_pembayaran']?> , pada hari <?php echo $hari.", ".$tgl_new_format?>. Sebesar Rp.<?php echo number_format($row['nominal'])?>. Sudah saya terima
								      				        
								        		" class="btn btn-success btn-sm pull-right" id="whatsappdone" data-action="share/whatsapp/share">SHARE<i class="fa fa-whatsapp"></i></a>
							          			<?php
							          		} else if($row[status] == "0"){
							  				?>
									          	<a style="margin-right: 1px;" href="whatsapp://send?text=Saya baru saja <?php echo $row['jenis'] ?> dengan ID Pembayaran <?php echo $row['id_pembayaran']?> , pada hari <?php echo $hari.", ".$tgl_new_format?>. Sebesar Rp.<?php echo number_format($row['nominal'])?>. Mohon segera di Reimburse.
										      				        
										        " class="btn btn-success btn-sm pull-right" id="whatsapp" data-action="share/whatsapp/share">SHARE<i class="fa fa-whatsapp"></i></a>
									          		<?php
									          	}
									          	?>
									          	<a style="margin-right: 1px;" href="whatsapp://send?text=Saya baru saja <?php echo $row['jenis'] ?> dengan ID Pembayaran <?php echo $row['id_pembayaran']?> , pada hari <?php echo $hari.", ".$tgl_new_format?>. Sebesar Rp.<?php echo number_format($row['nominal'])?>. Mohon segera di Reimburse.
										      				        
										        " class="btn btn-success btn-sm pull-right" id="whatsappbelum" data-action="share/whatsapp/share">SHARE<i class="fa fa-whatsapp"></i></a>
									          	<?php
									    
							          	}
							          	?>
						  <?php 

						  	if($one == "Admin"){
						  		?>
						  	  <script type="text/javascript">
				                  document.getElementById('editbtn').style.display="none";
				              </script>
						  		<?php
						  	}

							if($row[status] == "0" && $one == "Admin"){
						  		?>
						  	  <script type="text/javascript">
				                  document.getElementById('whatsappcek').style.display="none";
				              </script>
						  		<?php
						  	}						  	

						  	if($row[status] == "2"){
						  		?>
						  	  <script type="text/javascript">
				                  document.getElementById('whatsappbelum').style.display="none";
				              </script>
						  		<?php
						  	}

						  	if($row[status] == "2"){
						  		?>
						  	  <script type="text/javascript">
				                  document.getElementById('whatsappcek').style.display="none";
				              </script>
						  		<?php
						  	}

						  	if($row[status] == "1"){
						  		?>
						  	  <script type="text/javascript">
				                  document.getElementById('whatsappadmin').style.display="none";
				              </script>
						  		<?php
						  	}

						  	if($row[status] == "1"){
						  		?>
						  	  <script type="text/javascript">
				                  document.getElementById('whatsappbelum').style.display="none";
				              </script>
						  		<?php
						  	}

						  	if($row[status] == "2" || $row[status] == "1") {
						  		?>
						  	  <script type="text/javascript">
				                  document.getElementById('editbtn').style.display="none";
				              </script>
						  		<?php
						  	}

						  	if($one == "Admin"){
						  		$pesandari = $row['nama'];
						  	} else {
						  		$pesandari = "Admin";
						  	}
						  ?>
						 
						  </div>
							</section>  
						  <br><br>
						  <!-- Modal -->
						  <div class="modal fade" id="myModal_pesan" role="dialog">
						    <div class="modal-dialog">
						    
						      <!-- Modal content-->
						      <div class="modal-content">
							        <div class="modal-header">
							          <button type="button" class="close" data-dismiss="modal">&times;</button>
							          <h4 class="modal-title" id="pesan">Pesan konfirmasi dari : <?php echo $pesandari ?></h4>
							        </div>
							        <form method="POST" action="pages/proses/proses_konfirmasi.php">
							        <?php 
							        	  $sql_konfirm = "SELECT * FROM tb_konfirmasi WHERE id_pembayaran='$id_pembayaran'";
										  $result_konfirm=mysqli_query($koneksi, $sql_konfirm);
								          $values=mysqli_fetch_assoc($result_konfirm);
								          $status_admin = $values['konfirm_admin'];
								          $status_anggota = $values['konfirm_anggota'];

								          $sql_cek = "SELECT * FROM tb_pembayaran WHERE id_pembayaran='$id_pembayaran'";
								          $result_cek = mysqli_query($koneksi, $sql_cek);
								          $values_cek = mysqli_fetch_assoc($result_cek);
								          $status = $values_cek['status'];

							        if($one!="Admin"){
							        	
							        	if($status_admin != "2" && $status != "2"){
								          ?>
								          <div class="modal-body">
								          	<p> Tunggu Admin Me-Review Pembayaran Anda </p>
								          </div>	
								          <?php
								        } else {
							        	?>
								        <div class="modal-body">
								        <p>
								        	Uang Pembayaran <b><?php echo $row['jenis']?></b> dengan ID Pembayaran <b><?php echo $row['id_pembayaran']?></b>, pada hari <b><?php echo $hari.", ".$tgl_new_format?></b>. Sebesar <b>Rp.<?php echo number_format($row['nominal'])?></b> sudah di Transfer ke Rekening Bank Anda, silahkan di cek.
								        </p>
								        <hr>
								        <p>
								        	Jika uang belum ada bisa di informasikan kembali langsug lewat <b>WHATSAPP</b>, Jika sudah masuk 
								        	silahkan langsung klik tombol <b>"KIRIM KONFIRMASI"</b>
								        </p>
								        </div>
								        }

							        <?php 
									} } 
									if($one == "Admin"){
										if($status == "2"){
											?>
											<div class="modal-body">
											<p> Pembayaran ini Sudah di Reimburse </p>
											</div>
											<?php
										} else {
										?>
										<div class="modal-body">
								        <p>
								        	Saya baru saja <b><?php echo $row['jenis']?></b> dengan ID Pembayaran <b><?php echo $row['id_pembayaran']?></b> , pada hari <b><?php echo $hari.", ".$tgl_new_format?></b>. Sebesar <b>Rp.<?php echo number_format($row['nominal'])?></b>. Mohon segera di Reimburse.
								        </p>
								        <hr>
								        <p>	Jika sudah melakukan Reimburse, klik <b>"KIRIM KONFIRMASI"</b> </p>
								        </div>
									<?php
									}}
							        ?>
							        <div class="modal-footer">

							          <?php 
							          		if($one != 'Admin'){
								          	
								          		if($status == "2" ){
								          			?>
								          					<input type="submit" name="submit" value="KIRIM KONFIRMASI" class="btn btn-danger btn-sm" disabled>  
								          			<?php
								          	
								          		} else if($status=="0" || $status == "1") {
								          	
								          		if($status_admin != "2"){
								          			?>
								          				  	<input type="submit" name="submit" value="BELUM DI CEK OLEH ADMIN" class="btn btn-danger btn-sm" disabled>  
								          			<?php
								          		} else if($status_admin == "2"){
								          			?>
								          			  		<input type="submit" name="submit" value="KIRIM KONFIRMASI" class="btn btn-danger btn-sm">  
								          			<?php
								          		} 
								          	}

							          	} else if($one == 'Admin'){
							          		 
							          		 if($status == "2" ){
								          			?>
								          					<input type="submit" name="submit" value="KIRIM KONFIRMASI" class="btn btn-danger btn-sm" disabled>  
								          			<?php
								          			
								          		} else if($status == "0" || $status=="1") {

								          		if($status_admin == "2"){
									          		?>
									          				<input type="submit" name="submit" value="KONFIRMASI TERKIRIM" class="btn btn-danger btn-sm" disabled>  
									          		<?php
									          		} else if($status_admin != "2"){
									          		?>
									          				<input type="submit" name="submit" value="KIRIM KONFIRMASI" class="btn btn-danger btn-sm">  
									          		<?php
								          		} 
								          	}
							          	}
							          ?>
							          <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">CLOSE</button>
						        	</div>
						      </div>
						    </div>
						  </div>
					    <?php } ?>
					 	
					 	<?php 

                if($status_admin != "2" && $status != "2" && $status_anggota != "2"){
                  ?>
                  <script type="text/javascript">
                          document.getElementById('whatsapp').style.display="none";
                      </script>
                  <?php
                } else  {
                  ?>
                  <script type="text/javascript">
                          document.getElementById('whatsapp').style.visibility="visible";
                      </script>
                  <?php
                }
              ?>
              <?php
              if($status == "2"){
                  ?>
                  <script type="text/javascript">
                          document.getElementById('btnkonfirm').style.display="none";
                      </script>
                  <?php
								}
							}
?>
				</div>
		</body>
</html>