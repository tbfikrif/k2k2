<?php
if (!defined('DIDALAM_INDEX_PHP')) {
    //echo "Dilarang broh!";
    header("Location: ../../tampil/home");
}
if (strpos($_SESSION['jabatan'], 'Admin') === false) {
    echo '<script>alert("Maaf, Anda bukan Admin"); window.location="tampil/home"</script>';
}
?>
	<div class="container bounceInUp animated">
		<div class="content-header bounceInRight animated">
			<h2>DATA AKOMODASI</h2>
			<button id="modeDetailAkomodasi" class="btn btn-primary" data-toggle="collapse" data-target="#detailAkomodasi">Detail Akomodasi</button>
			<button id="modeMasterAkomodasi" class="btn btn-info" data-toggle="collapse" data-target="#masterAkomodasi">Master Akomodasi</button>
		</div>
			<div class="row collapse flipInX animated" id="masterAkomodasi">
					<div class="col-md-4">
						<h3> FORM TAMBAH DATA </h3>
						<!-- form start -->
						<form role="form" action="pages/proses/proses_save-credits.php" method="POST">
							<div class="box-body" style="margin-right: 20px;">
								<?php

								$sql_query1 = "SELECT id_anggota,nama FROM tb_anggota WHERE id_anggota NOT IN (SELECT id_anggota FROM tb_credits_anggota)";
								$result1 = mysqli_query($koneksi, $sql_query1);
								?>
									<div class="form-group">
										<label>Nama Anggota</label>
										<br>
										<select class="form-control select2 btn-primary" data-placeholder="Pilih ID Anggota" name="id_anggota1" id="id_anggota1" style="width:250px">
											<?php
											while ($row1 = mysqli_fetch_array($result1)) {
											?>
												<option value="<?php echo $row1['id_anggota']; ?>">
													<?php echo $row1["id_anggota"] . " - " . $row1["nama"]; ?> </option>
												<?php
											}
											?>
										</select>
									</div>
									<div class="form-group">
										<label for="Credit">Uang Transportasi</label>
										<input type="text" class="form-control" id="topup_credit1" name="topup_credit1" placeholder="Isi Jumlah Uang Transportasi"
										 data-validation="required" data-validation-error-msg="Field Jumlah Uang Transportasi Tidak Boleh Kosong !">
									</div>
									<div class="form-group">
										<label for="Credit">Uang Makan</label>
										<input type="text" class="form-control" id="topup_credit2" name="topup_credit2" placeholder="Isi Jumlah Uang Makan"
										 data-validation="required" data-validation-error-msg="Field Jumlah Uang Transportasi Tidak Boleh Kosong !">
									</div>
									<!--
							<div class="form-group">
							  <label for="Gaji">Total Credit</label>
							  <input type="text" class="form-control" id="total_credit" name="total_credit" placeholder="Isi Total Credit"
							  data-validation="required" data-validation-error-msg="Field Total Credit Tidak Boleh Kosong !">
							</div>
							-->
									<button type="submit" name="submit_credit" class="btn btn-primary">Tambah Data</button>
							</div>
							<!-- /.box-body -->
						</form>
					</div>

					<!-- left column -->
					<?php
						$query3 = "SELECT a.id,a.id_anggota,b.nama,a.topup_credit,a.uang_makan FROM tb_credits_anggota a JOIN tb_anggota b ON a.id_anggota=b.id_anggota";
						$res3=mysqli_query($koneksi, $query3);
					?>
					<div class="col-md-8">
							<div class="table-responsive">
								<table class="table" id="data_credits">
									<thead>
										<tr>
											<th>ID Anggota</th>
											<th>Nama</th>
											<th>Uang Transportasi</th>
											<th>Uang Makan</th>
											<th>Action</th>
										</tr>
									</thead>
									<tbody>
									<?php
										while ($row3 = mysqli_fetch_array($res3)) {
									?>
									<tr>
										<td><a id="<?php echo $row3["id_anggota"] ?> " class="btn btn-default btn-xs view_data_anggota"><?php echo $row3["id_anggota"] ?></a></td>
										<td><?php echo $row3["nama"] ?> </td>
										<td>Rp.<?php echo number_format($row3["topup_credit"]) ?> </td>
										<td>Rp.<?php echo number_format($row3["uang_makan"]) ?> 
										</td>
										<td><a id="<?php echo $row3["id"]; ?>" class="btn btn-warning btn-xs edit_topup_credit">EDIT</a></td>
										<?php
										}
										?>
									</tbody>
								</table>
							</div>
					</div>
			</div>
		<div id="detailAkomodasi">
		<br>
		<br>
		<?php
		$paidStatus=isset($_POST['status_paid']);
          if ($paidStatus) {
            $query2 = "SELECT a.id_anggota AS id_anggota,b.nama AS nama,(c.topup_credit+c.uang_makan) AS jumlah,DATE_FORMAT(a.tanggal,'%Y-%m') AS bulan,SUM(a.credit_in) AS total,a.credit_stat AS status FROM tb_detail_absen a JOIN tb_anggota b ON a.id_anggota=b.id_anggota JOIN tb_credits_anggota c ON a.id_anggota=c.id_anggota WHERE a.credit_stat='paid' GROUP BY bulan,a.id_anggota ORDER BY bulan DESC";
            $query_total = "SELECT SUM(a.credit_in) AS total FROM tb_detail_absen a JOIN tb_credits_anggota b ON a.credit_id=b.id WHERE a.credit_stat='paid'";
          } else {
			$query2 = "SELECT a.id_anggota AS id_anggota,b.nama AS nama,(c.topup_credit+c.uang_makan) AS jumlah,DATE_FORMAT(a.tanggal,'%Y-%m') AS bulan,SUM(a.credit_in) AS total,a.credit_stat AS status FROM tb_detail_absen a JOIN tb_anggota b ON a.id_anggota=b.id_anggota JOIN tb_credits_anggota c ON a.id_anggota=c.id_anggota WHERE a.credit_stat='unpaid' GROUP BY a.id_anggota,bulan";
			//$query2 = "SELECT a.id_anggota AS id_anggota,b.nama AS nama,c.topup_credit AS jumlah,DATE_FORMAT(a.tanggal,'%Y-%m') AS bulan,SUM(a.credit_in) AS total,a.credit_stat AS status FROM tb_detail_absen a JOIN tb_anggota b ON a.id_anggota=b.id_anggota JOIN tb_credits_anggota c ON a.id_anggota=c.id_anggota WHERE a.credit_stat='unpaid' AND MONTH(a.tanggal)=MONTH(CURRENT_DATE()) AND YEAR(a.tanggal)=YEAR(CURRENT_DATE()) GROUP BY a.id_anggota";
            $query_total = "SELECT SUM(a.credit_in) AS total FROM tb_detail_absen a JOIN tb_credits_anggota b ON a.credit_id=b.id WHERE a.credit_stat='unpaid' AND MONTH(a.tanggal)=MONTH(CURRENT_DATE()) AND YEAR(a.tanggal)=YEAR(CURRENT_DATE())";
          }
			$result2 = mysqli_query($koneksi, $query2);
		?>
			<div class="form-group flipInX animated">
				<label> FILTER STATUS </label>
				<form method="POST" action="tampil/data-akomodasi">
					<div class="input-group">
						<a href="tampil/data-akomodasi" class="btn btn-danger btn-xs">UNPAID</a>
						<input type="submit" name="status_paid" value="PAID" class="btn btn-success btn-xs" style="margin-left: 3px;">
					</div>
				</form>
			</div>
			<div class="table-responsive">
				<table class="table" id="detail_credits">
					<thead>
						<tr>
							<th> ID Anggota</th>
							<th> Nama </th>
							<?php
								if (!$paidStatus) {
							?>
								<th> Uang Makan + Transportasi</th>
								<?php
									}
								?>
									<th> Bulan</th>
									<th> Total</th>
									<th> Status</th>
									<?php
										if (!$paidStatus) {
									?>
										<th>Action</th>
										<?php
											}
										?>
						</tr>
					</thead>
					<tbody>
						<?php
							$no = 1;
							while ($row2 = mysqli_fetch_array($result2)) {
						?>
							<tr>
								<td>
								<a id="<?php echo $row2["id_anggota"] ?> " class="btn btn-default btn-xs view_data_anggota"><?php echo $row2["id_anggota"] ?>  </a></td>
								<td>
									<?php echo $row2["nama"] ?> </td>
								<?php
									if (!$paidStatus) {
								?>
									<td>Rp.
										<?php echo number_format($row2['jumlah']) ?> </td>
									<?php
									}
									?>
										<td>
											<?php echo $row2["bulan"] ?>
										</td>
										<td>Rp.
											<?php echo number_format($row2['total']) ?> </td>
										<td>
											<?php
											if ($row2["status"] == "paid") {
													echo '<span class="label label-success">' . strtoupper($row2['status']) . '</span>';
												} else {
													echo '<span class="label label-danger">' . strtoupper($row2['status']) . '</span>';
												}
											?>
										</td>
										<?php
											if ($row2["status"] != "paid") {
										?>
											<td>
												<a id="<?php echo $row2["id_anggota"]; ?>" class="btn btn-info btn-xs paid_total_credit" style="float:left;">BAYAR</a>
											</td>
											<?php
											}
											?>

							</tr>
							<?php
								$no++;
								}
					?>
					</tbody>
					<tfoot>
						<tr>
							<?php
								$result_total = mysqli_query($koneksi, $query_total);
								$row_total = mysqli_fetch_assoc($result_total);
							?>
								<?php
									if (!$paidStatus) {
								?>
									<th>Total</th>
									<th></th>
									<?php
										} else {
									?>
										<th>Total</th>
										<?php
											}
										?>
											<th></th>
											<th></th>

											<th>Rp.
												<?php echo number_format($row_total["total"]) ?>
											</th>
											<th></th>
											<?php
												if (!$paidStatus) {
											?>
												<th>
													<a class="btn btn-success btn-xs paid_all_total_credit">BAYAR SEMUA BULAN INI</a>
												</th>
												<?php
											}
											?>
						</tr>
					</tfoot>
				</table> 
			</div>
		</div>
	</div>
		<div id="dataModal" class="modal fade">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title">Hapus Data</h4>
					</div>
					<div class="modal-body" id="credit_detail_hapus">
					</div>
					<div class="modal-footer">
						<a href="pages/proses/proses_delete-credit.php" class="btn btn-danger">HAPUS</a>
						<button type="button" class="btn btn-default" data-dismiss="modal">CLOSE</button>
					</div>
				</div>
			</div>
		</div>

		<div id="editCreditModal" class="modal fade">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title">EDIT DATA AKOMODASI</h4>
					</div>
					<div class="modal-body">
						<form method="post" action="pages/proses/proses_edit-credit.php">
							<label>ID</label>
							<input type="text" name="id_credit" id="id_credit" class="form-control" readonly />
							<br>
							<label>ID Anggota</label>
							<input type="text" name="id_anggota_credit" id="id_anggota_credit" class="form-control" readonly />
							<br>
							<label>Uang Transportasi</label>
							<input type="text" name="topup_credit" id="topup_credit" class="form-control" />
							<label>Uang Makan</label>
							<input type="text" name="uang_makan" id="uang_makan" class="form-control" />
					</div>
					<div class="modal-footer">
						<input type="submit" name="submit" id="insert" value="Update" class="btn btn-success" />
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
						</form>
					</div>
				</div>
			</div>
		</div>

		<div id="paidCreditModal" class="modal fade">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title">Bayar Total Akomodasi</h4>
					</div>
					<div class="modal-body" id="credit_detail_paid">
					</div>
					<div class="modal-footer">
						<a href="pages/proses/proses_reset-credit.php" class="btn btn-info">BAYAR</a>
						<button type="button" class="btn btn-default" data-dismiss="modal">CLOSE</button>
					</div>
				</div>
			</div>
		</div>

		<div id="resetTotalModal" class="modal fade">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title">Bayar Semua Total Akomidasi Bulan ini</h4>
					</div>
					<div class="modal-body" id="credit_all_reset">
					</div>
					<div class="modal-footer">
						<a href="pages/proses/proses_reset-all-credit.php" class="btn btn-info">Bayar</a>
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