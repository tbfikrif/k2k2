<?php
   if (!defined('DIDALAM_INDEX_PHP')){ 
    //echo "Dilarang broh!";
        header("Location: ../../tampil/home");
		}
		if (strpos($_SESSION['jabatan'], 'Admin')===false) {
      echo '<script>alert("Maaf, Anda bukan Admin"); window.location="tampil/home"</script>';
   }
?>

<div class="container bounceInUp animated">
	<hr>
	<h2> DATA CUTI </h2>
		<div class="row">
			<div class="col-md-4">
				<h3> FORM TAMBAH DATA </h3>
				 <!-- form start -->
					<form role="form" action="pages/proses/proses_save-cutiquota.php" method="POST">
					  <div class="box-body" style="margin-right: 20px;">
						<?php
							$sql_query1 = "SELECT tb_anggota.id_anggota,tb_anggota.nama FROM tb_anggota WHERE tb_anggota.id_anggota NOT IN (SELECT tb_cuti_anggota.id_anggota FROM tb_cuti_anggota)";
							$result = mysqli_query($koneksi, $sql_query1);
						?>      
					  <div class="form-group">
						<label>ID Anggota</label>
						<select class="form-control select2 btn-primary" data-placeholder="Pilih ID Anggota" name="id_anggota1" id="id_anggota1">
								<?php
								while ($row = mysqli_fetch_array($result)) {
								?>
								<option value="<?php echo $row[id_anggota]; ?>"> <?php echo $row["id_anggota"]." - ".$row["nama"]; ?> </option>
								<?php
								}
									?>
						</select>
					  </div>
						<div class="form-group">
						  <label for="Credit">Quota Cuti</label>
						  <input type="text" class="form-control" id="quotacuti1" name="quota_cuti1" placeholder="Isi Jumlah Quota Cuti"
						  data-validation="required" data-validation-error-msg="Field Quota Cuti Tidak Boleh Kosong !">
						</div>
						<!--
						<div class="form-group">
						  <label for="Gaji">Total Credit</label>
						  <input type="text" class="form-control" id="total_credit" name="total_credit" placeholder="Isi Total Credit"
						  data-validation="required" data-validation-error-msg="Field Total Credit Tidak Boleh Kosong !">
						</div>
						-->
						<button type="submit" name="submit_cuti" class="btn btn-primary">Tambah Data</button>
					  </div>
					  <!-- /.box-body -->
					</form>
			</div>       
			
			<!-- left column -->
			<div class="col-md-8">
				<?php
				   $query = "SELECT s.id_anggota,a.nama,s.cuti_used,s.cuti_qty FROM tb_cuti_anggota s JOIN tb_anggota a WHERE s.id_anggota=a.id_anggota";
				   $result = mysqli_query($koneksi, $query);
				?>
				<h3> LIST CUTI </h3>
					<div class="table-responsive">  
					   <table class="table" id="data_cuti">
						   <thead>
							  <tr>  
									 <th> ID Anggota</th>
									 <th> Nama </th>  
									 <th> Cuti Terpakai </th>
									 <th> Quota Cuti </th>                         
									 <th> Action </th>
							  </tr>
						   </thead>
						   <tbody>
								<?php
								$no = 1;
								while ($row = mysqli_fetch_array($result)) {
							?>
							  <tr>   
								 <td><a id="<?php echo $row["id_anggota"] ?> " class="btn btn-default btn-xs view_data_anggota"><?php echo $row["id_anggota"] ?> </a></td>
								 <td> <?php echo $row["nama"] ?> </td>
								 <td> <?php echo $row["cuti_used"] ?> </td>
								 <td> <?php echo $row["cuti_qty"] ?> </td>
								 <td><a id="<?php echo $row["id_anggota"]; ?>" class="btn btn-warning btn-xs edit_quota">UPDATE</a><a id="<?php echo $row["id_anggota"]; ?>" class="btn btn-info btn-xs reset_quotaUsed">RESET</a></td>
							  </tr>
							<?php
							$no++;
								}
							?>
						   </tbody>
							<tfoot>
								<tr>
								  <th>Total</th>
								  <th></th>
								  <?php
								   $query_total = "SELECT SUM(cuti_used) AS sum_cuti_used FROM tb_cuti_anggota";
								   $result_total = mysqli_query($koneksi, $query_total);
								   $row_total = mysqli_fetch_assoc($result_total);
								  ?>
								  <th><?php echo $row_total["sum_cuti_used"] ?></th>
								  <th></th>
								  <th><a class="btn btn-danger btn-xs reset_all_cuti_used">RESET ALL CUTTI</a></th>
								</tr>
							</tfoot>
					   </table
					</div>
			</div>
		</div>  
</div>      
</div>

 <div id="cuti_Modal" class="modal fade">  
      <div class="modal-dialog">  
           <div class="modal-content">  
                <div class="modal-header">  
                     <button type="button" class="close" data-dismiss="modal">&times;</button>  
                     <h4 class="modal-title">EDIT QUOTA CUTI</h4>  
                </div>  
                <div class="modal-body">  
                     <form method="post" action="pages/proses/proses_edit-cuti.php">  
                          <label>ID Anggota</label>
                          <input type="text" name="id_anggota" id="id_anggota" class="form-control" readonly />   
                          <br />
                          <label>Quota Cuti</label>  
                          <input type="text" name="cuti_quota" id="cuti_quota" class="form-control" />                    
                </div>  
                <div class="modal-footer"> 
                     <input type="submit" name="submit" id="insert" value="Update" class="btn btn-success" /> 
                     <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>  
                </form>      
                </div>  
           </div>  
      </div>  
 </div>  
<div id="resetModal" class="modal fade">  
      <div class="modal-dialog">  
           <div class="modal-content">  
                <div class="modal-header">  
                     <button type="button" class="close" data-dismiss="modal">&times;</button>  
                     <h4 class="modal-title">Reset Cuti Terpakai</h4>  
                </div>  
                <div class="modal-body" id="cuti_detail_reset">  
                </div>  
                <div class="modal-footer">    
                     <a href="pages/proses/proses_reset-cutiused.php" class="btn btn-info">Reset</a>
                     <button type="button" class="btn btn-default" data-dismiss="modal">CLOSE</button>  
                </div>  
           </div>  
      </div>  
 </div>  

 <div id="resetCutiModal" class="modal fade">  
      <div class="modal-dialog">  
           <div class="modal-content">  
                <div class="modal-header">  
                     <button type="button" class="close" data-dismiss="modal">&times;</button>  
                     <h4 class="modal-title">Reset All Cuti Terpakai</h4>  
                </div>  
                <div class="modal-body" id="cuti_all_reset">  
                </div>  
                <div class="modal-footer">    
                     <a href="pages/proses/proses_reset-all-cuti.php" class="btn btn-info">Reset All</a>
                     <button type="button" class="btn btn-default" data-dismiss="modal">CLOSE</button>  
                </div>  
           </div>  
      </div>  
 </div>
 <div id="dataModalAnggota" class="modal fade">
			<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Detail Anggota</h4>
				</div>
				<div class="modal-body" id="employee_detail">
				</div>
				<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">CLOSE</button>
				</div>
			</div>
			</div>
		</div>  
