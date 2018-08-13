
<?php 
  if (!defined('DIDALAM_INDEX_PHP')){ 
     //echo "Dilarang broh!";
     header("Location: ../../tampil/home");
  }
error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
?>

	<?php 
		  include "../con_db.php";
		  session_start();

   		  $tgl_now = date("d-m-Y"); 
		  $day = date('j', strtotime($tgl_now));
		  $month = date('F', strtotime($tgl_now));
		  $year = date('Y', strtotime($tgl_now));

		  
		  $id_pembayaran = $_GET['id'];
		  $_SESSION['id_pembayaran'] = $id_pembayaran;

		  $idjenis = $_GET['id_jenis'];

		  $sql = "SELECT tb_pembayaran.id_pembayaran, tb_anggota.id_anggota, tb_anggota.nama, tb_pembayaran.tanggal, tb_jenistransaksi.jenis, tb_pembayaran.nominal, tb_pembayaran.keterangan, tb_pembayaran.status FROM `tb_pembayaran`JOIN `tb_anggota` ON tb_pembayaran.id_anggota = tb_anggota.id_anggota JOIN tb_jenistransaksi ON tb_pembayaran.id_jenis = tb_jenistransaksi.id_jenis WHERE tb_pembayaran.id_pembayaran='$id_pembayaran'";

		  $result=mysqli_query($koneksi,$sql);

		   if (!$result) {
              printf("Error: %s\n", mysqli_error($koneksi));
              exit();
              } 

          $sql_bukti = "SELECT * FROM tb_buktipembayaran WHERE id_pembayaran = '$id_pembayaran' AND bukti <> ''";
          $result_bukti = mysqli_query($koneksi, $sql_bukti);   

	?>
				<div>
					<h2 style="float: right;"> <?php echo $day." - ".$month." - ".$year; ?> </h2>
					<hr>
					  <h2>FORM PEMBAYARAN</h2> 
					  <hr style="border-color:#000000;">
					  <br>

					<?php
							while ($row=mysqli_fetch_array($result)) {	
					?>
					<section class="content-header" >
						<div class="container" style="width: 80%;"> 
							<form action="pages/proses/proses_edit-pembayaran.php" method="POST" enctype="multipart/form-data">   
							    <div class="form-group">
							      <label for="id_pembayaran">ID</label>
							      <input type="text" class="form-control" id="id_pembayaran" placeholder="Id Pembayaran" name="id_pembayaran" value="<?php echo $row['id_pembayaran']; ?>" readonly>
							    </div>

							    <div class="form-group">
							      <label for="Id_anggota">ID Anggota</label>
							      <input type="text" class="form-control" id="id_anggota" name="id_anggota" value="<?php echo $row['id_anggota'];?>" readonly >
							    </div>

							    		<div class="form-group">
									      <label for="jenis"> Jenis Pembayaran </label>
									      <select class="form-control" id="jenis" name="jenis">

									<?php
											$sql2 = "SELECT * FROM tb_jenistransaksi WHERE id_jenis = '$idjenis'";
									        $result2 = mysqli_query($koneksi, $sql2);

									        while ($r = mysqli_fetch_array($result2)) {
									          ?>	
									          	<option value="<?php echo $r[id_jenis]?>" selected="selected"> <?php echo $r[jenis]; ?> </option>
									        <?php
									        } 

									        $sql = "SELECT * FROM tb_jenistransaksi WHERE id_jenis <> '$idjenis'";
									        $result = mysqli_query($koneksi, $sql);

									   		while ($r = mysqli_fetch_array($result)) {
									          ?>	
									          	<option value="<?php echo $r[id_jenis]?>"> <?php echo $r[jenis]; ?> </option>
									        <?php
									        } 
									        ?>
									        
									      </select>
									    </div>
									    <script type="text/javascript">
									      
									      $(function(){
									        // Set up the number formatting.
									        
									        $('#nominal').on('change',function(){
									          console.log('Change event.');
									          var val = $('#nominal').val();
									          $('#the_number').text( val !== '' ? val : '(empty)' );
									        });
									        
									        $('#nominal').change(function(){
									          console.log('Second change event...');
									        });
									        
									        $('#nominal').number(true);
									      });
									    </script>								    

							    <div class="form-group">
							      <label for="nominal"> Nominal </label>
							      <input class="form-control" type="text" id="numeric" name="nominal" value="<?php echo $row['nominal']?>" data-validation="required">
							    </div>

							    <div class="form-group">
							      <label for="keterangan"> Keterangan </label>
							      <textarea class="form-control" rows="5" data-validation="required" id="keterangan" name="keterangan" placeholder="Keterangan Pembayaran"> <?php echo $row['keterangan']; ?> </textarea>
							    </div>

							     <div class="form-group">
							      <label for="pass"> Bukti Pembayaran </label>
							      <input class="form-control" type="file" name="bukti"/>
							    </div>
							<?php } ?>
					</div>

					<br>
					<br>
					<div class="box-header">
                    <h3 class="box-title">LIST BUKTI PEMBAYARAN</h3>
                    <div class="box-tools">
                    <button type="button" class="btn btn-box-tool" data-target="#table" data-toggle="collapse" ><i class="fa fa-minus"></i></button>
                    </div>
                 	</div>
                 	<hr style="border-color:#3c8dbc;">	
                 	<div class="collapse" id="table">
 					<table class="table-bordered" style="border-color: #424242;">
 					<thead>
	 					<tr>
	 						<th style="text-align: center; width: 50%"> FILE NAME </th>
	 						<th style="text-align: center;"> GAMBAR </th> 
	 						<th style="text-align: center; width: 50%;"> ACTION </th>
	 					</tr>
	 				</thead>	
					  <?php 
					  	while ($r = mysqli_fetch_array($result_bukti)){
					  		$path = $r[bukti];
					  		?>	 
					 <tbody>	
					 	<tr> 		
					 			<td>
					 				<?php echo $path?>
					 			</td>	
							    <td style="text-align:center; display: block;"> 
							      <a class='popupimage' href='<?php echo "dist/fotobukti/".$path; ?>' data-target="#myModal_img">
							      	<img <?php echo "src='dist/fotobukti/".$path."'"; ?> class="img-responsive" width="100" height="60">
							      </a>
							     </td>
							     <td style="text-align: center;"> 
							     <input type="button" name="delete" id="<?php echo $r[id] ?>" class="btn btn-danger delete_data" value="HAPUS">
							     </td>
					 </tr>
					 </tbody>
					   <?php
					  	}
					  ?>
					</table>

							<div id="dataModal_hapus" class="modal fade">  
							      <div class="modal-dialog">  
							           <div class="modal-content">  
							                <div class="modal-header">  
							                     <button type="button" class="close" data-dismiss="modal">&times;</button>  
							                     <h4 class="modal-title">Hapus Bukti Pembayaran</h4>  
							                </div>  
							                <div class="modal-body" id="bukti">  
							                </div>  
							                <div class="modal-footer">  
							                     <a href="pages/proses/proses_delete-bukti.php" class="btn btn-danger">HAPUS GAMBAR</a>    
							                     <button type="button" class="btn btn-default" data-dismiss="modal">CLOSE</button>  
							                </div>  
							           </div>  
							      </div>  
							 </div>  

					<script>
					     $(document).ready(function(){  
					      $('.delete_data').click(function(){  
		         				var id = $(this).attr("id");
					              $.ajax({  
					                url:"pages/fetchdata/fetch_data_bukti-pembayaran.php",  
					                method:"post",  
					                data:{id:id},  
					                success:function(data){
					               	 $('#bukti').html(data);    
					                 $('#dataModal_hapus').modal("show");  
					         	}
					         }); 
					      });  
					 });  
					             
					</script>
				  
				  </div>			  		
				  <hr style="border-color:#3c8dbc;">		
				  <input type="submit" name="submit" value="SAVE CHANGES" class="btn btn-success pull-right">
				  </div>
				  </form>
						<!--Close Form Group -->
					    <div class="modal fade" id="myModal_img" role="dialog">
						    <div class="modal-dialog">
						    	<div class="modal-header">
						    		<a class="close" data-dismiss="modal" style="color: #ffffff;">CLOSE</a>
						  	    </div>
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

					    <?php  list($one, $two) = explode(",", $_SESSION['jabatan'] , 2); ?>

					    <!-- Trigger the modal with a button -->
						  <?php 
						  	if($one == "Admin"){
						  ?>
						  	  <script type="text/javascript">
				                  document.getElementById('editbtn').style.display="none";
				              </script>
						  <?php
						  	}
						  ?>
						 
						</div>

					</section>  			 