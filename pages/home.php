
<?php
  if (!defined('DIDALAM_INDEX_PHP')){ 
     //echo "Dilarang broh!";
     header("Location: ../tampil/home");
     exit();
  } else {
?>
<!-- jQuery 3 -->
<style>
    canvas {
        -moz-user-select: none;
        -webkit-user-select: none;
        -ms-user-select: none;
    }
    #js-legend ul {
      list-style: none;
    }

    #js-legend ul li{
      display: inline;
      padding-left: 30px;
      position: relative;
      margin-bottom: 4px;
      border-radius: 5px;
      padding: 2px 8px 2px 28px;
      font-size: 14px;
      cursor: default;
      -webkit-transition: background-color 200ms ease-in-out;
      -moz-transition: background-color 200ms ease-in-out;
      -o-transition: background-color 200ms ease-in-out;
      transition: background-color 200ms ease-in-out;
    }

    #js-legend li span {
      display: block;
      position: absolute;
      left: 0;
      top: 0;
      width: 20px;
      height: 100%;
      border-radius: 5px;
	}
	.chartjs-hidden-iframe {
		height: 100% !important;
	}
  /* Sembunyikan carousel-control */
  .carousel .carousel-control { visibility: hidden; }
  .carousel:hover .carousel-control { visibility: visible; }
  /* End Sembunyikan carousel-control */
</style>
 <!-- Content Header (Page header) -->
<body onload="loadChartKakatu();checkAbsensi();">
    <section class="content-header">
    <?php
      date_default_timezone_set('Asia/Jakarta');
      $tgl_now = date("d-m-Y");
      $dayname = date('D', strtotime($tgl_now));
      $day = date('j', strtotime($tgl_now));
      $month = date('F', strtotime($tgl_now));
      $year = date('Y', strtotime($tgl_now));
    ?>  
      
      <h3 class="pull-right" style="float: right;"> <?php echo $dayname." , ".$day." - ".$month." - ".$year; ?> </h3>
      
    </section>

    <br>
    <br>
    <br>

      <!-- Main content -->
       <!-- Small boxes (Stat box) -->
      <div class="row" id="shortcut-box">
        <div class="col-lg-4 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-aqua">
            <div class="inner">
            <b><p style="font-size: 27px;">AIR</p></b>

              <p>Shortcut Pembayaran</p>
            </div>
            <div class="icon">
              <i class="ion ion-waterdrop"></i>
            </div>
            <a href="tampil/form-bayar/air" class="small-box-footer">Klik Disini <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-4 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-green">
            <div class="inner">
            <b><p style="font-size: 27px;">Listrik</p></b>

              <p>Shortcut Pembayaran</p>
            </div>
            <div class="icon">
              <i class="ion ion-flash"></i>
            </div>
            <a href="tampil/form-bayar/listrik" class="small-box-footer">Klik Disini <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-4 col-xs-6">
          <!-- small box -->
          <div class="small-box" style="background-color: #fffc4c;">
            <div class="inner">
            <b><p style="font-size: 27px; color: #35352b;">ART</p></b>

              <p style="color: #35352b;">Shortcut Pembayaran</p>
            </div>
            <div class="icon">
              <i class="ion ion-home"></i>
            </div>
            <a href="tampil/form-bayar/ART" class="small-box-footer" style="color: #35352b;">Klik Disini <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-4 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-red">
            <div class="inner">
              <b><p style="font-size: 27px;">Transport</p></b>

              <p>Shortcut Pembayaran</p>
            </div>
            <div class="icon">
              <i class="ion ion-model-s"></i>
            </div>
            <a href="tampil/form-bayar/transport" class="small-box-footer">Klik Disini <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-4 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-primary">
            <div class="inner">
            <b><p style="font-size: 27px;">Konsumsi</p></b>

              <p>Shortcut Pembayaran</p>
            </div>
            <div class="icon">
              <i class="ion ion-spoon"></i><i class="ion ion-fork"></i>
            </div>
            <a href="tampil/form-bayar/konsumsi" class="small-box-footer">Klik Disini <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-4 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-yellow">
            <div class="inner">
            <b><p style="font-size: 27px;">Sampah</p></b>

              <p>Shortcut Pembayaran</p>
            </div>
            <div class="icon">
              <i class="ion ion-trash-a"></i>
            </div>
            <a href="tampil/form-bayar/sampah" class="small-box-footer">Klik Disini <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
      </div>
      <!-- /.row -->
		 <!-- Apply any bg-* class to to the info-box to color it -->
	 
   <!-- DONUT CHART -->
		<div class="row" id="updateAbsensiHariIni" style="display:none">
			<div class="col-md-12">
					   <!-- BAR CHART -->
				  <div class="box box-info">
					<div class="box-header with-border">
					  <h3 class="box-title">Statistik Absensi Seluruh Pegawai Hari Ini</h3>
					  <div class="box-tools pull-right">
						<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
						<!--<button id="removeChartAbsensiHariIni" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>-->
					  </div>
					</div>
					<div class="box-body">
							  <div class="col-md-4">
								  <div class="row">
										  <ul class="chart-legend clearfix list-inline">
											  <li id="listHadir"><span class="list-inline-item label label-info badge" id="jumhadir" ></span>Hadir</li>
											  <li id="listHadirDiluar"><span class="list-inline-item label label-primary badge" id="jumhadirdiluar"></span>Tugas Kantor</li>
											  <li id="listSakit"><span class="list-inline-item label label-danger badge" id="jumsakit"></span>Sakit</li>
											  <li id="listIzin"><span class="list-inline-item label label-warning badge" id="jumizin"></span>Izin</li>
											  <li id="listCuti"><span class="list-inline-item label label-success badge" id="jumcuti"></span>Cuti</li>
                        <li id="listAlpha"><span class="list-inline-item label label-default badge" id="jumalpha"></span>Alpha</li>
                        <li id="listKerjaRemote"><span class="list-inline-item label label-default badge" id="jumkerjaremote"></span>Kerja Remote</li>
										  </ul>
									  <br>
									  <div class="chart-responsive col-md-12 col-md-pull-2">
										  <canvas id="chart_absensi-hari-ini"></canvas>
                    </div>
								  </div>
							  </div>
							  <div class="col-md-8">
									<div id="galleryFotoAbsensi"></div>
                </div>
                <ul class="chart-legend clearfix list-inline">
                      <li id="listOntime"><span style="border-radius: 50%;width: 20px;height: 20px;padding-top: 5px;padding-right: 8px;padding-bottom: 5px;padding-left: 8px;background: #fff;border: 3px solid aqua;color: #666;text-align: center;font: 13px Arial, sans-serif;" class="list-inline-item" id="jumOntime"></span> On Time</li>
                      <li id="listLate"><span style="border-radius: 50%;width: 20px;height: 20px;padding-top: 5px;padding-right: 8px;padding-bottom: 5px;padding-left: 8px;background: #fff;border: 3px solid orange;color: #666;text-align: center;font: 13px Arial, sans-serif;" class="list-inline-item" id="jumLate"></span> Telat</li>
                      <li id="listTidakKerja"><span style="border-radius: 50%;width: 20px;height: 20px;padding-top: 5px;padding-right: 8px;padding-bottom: 5px;padding-left: 8px;background: #fff;border: 3px solid red;color: #666;text-align: center;font: 13px Arial, sans-serif;" class="list-inline-item" id="jumTidakKerja"></span> Tidak Kerja</li>
                      <li id="listBelumAbsen"><span style="border-radius: 50%;width: 20px;height: 20px;padding-top: 5px;padding-right: 8px;padding-bottom: 5px;padding-left: 8px;background: #fff;border: 3px solid #c0c0c0;color: #666;text-align: center;font: 13px Arial, sans-serif;" class="list-inline-item" id="jumBelumAbsen"></span> Belum Absen</li>
                </ul>
                <br>
							  <!-- ./chart-responsive -->
							<!-- /.col -->

							<!-- /.col -->
						  <!-- /.row -->
					</div>
					<!-- /.box-body -->
					  <div class="box-footer with-border">
						<h4 class="box-title">Progress Absensi Hari ini</h4>
						<div class="progress" id="progres-absen-hari-ini2">
							<div class="progress-bar " id="progres-absen-hari-ini" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width:0%">0%</div>
						</div>
					  </div>
				</div>
				  <!-- /.box -->
			</div>
        </div>
		<div class="row">
			<div class="col-md-6">
				   <!-- BAR CHART -->
			  <div class="box box-primary">
				<div class="box-header with-border">
				  <h3 class="box-title">Total Uang Akomodasi <?php if(strpos($_SESSION['jabatan'], 'Admin')===false){echo " Anda ";}?> yang telah dibayar tahun <?php echo $year;?></h3>

				  <div class="box-tools pull-right">
					<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
					<!--<button id="removeChartJumlahOperasional" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>	-->
				  </div>
				</div>
				<div class="box-body chart-responsive">
				  <div class="chart" id="credit-chart" style="height: 317px;position: relative;float:right;"></div>
				</div>
				<!-- /.box-body -->
			  </div>
			  <!-- /.box -->
			 </div>
			<div class="col-md-6">
					   <!-- BAR CHART -->
				  <div class="box box-info">
					<div class="box-header with-border">
					  <h3 class="box-title">Statistik Absensi <?php if(strpos($_SESSION['jabatan'], 'Admin')===false){echo " Anda ";}?> tahun <?php echo $year;?></h3>

					  <div class="box-tools pull-right">
						<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
            <!--<button id="removeChartSatistikAbsensi" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>-->
						</button>
					  </div>
					</div>
					<div class="box-body">
							  <ul class="chart-legend clearfix list-inline col-md-12 col-md-push-3">
                  <li><i class="fa fa-square text-aqua list-inline-item"></i>Hadir</li>
                  <li><i class="fa fa-square text-red list-inline-item"></i>Sakit</li>
                  <li><i class="fa fa-square text-yellow list-inline-item"></i>Izin</li>
                  <li><i class="fa fa-square text-green list-inline-item"></i>Cuti</li>
                  <li><i class="fa fa-square text-gray list-inline-item"></i>Alpha</li>
							  </ul>
							  <div class="chart-responsive">
								<div class="chart" id="absen-chart" style="height: 300px;position: relative;"></div>
							  </div>
					</div>
				  </div>
			</div>
		</div>
	 
	   <div class="row">
			 <div class="col-md-6">
				   <!-- BAR CHART -->
			  <div class="box box-warning">
				<div class="box-header with-border">

				  <h3 class="box-title">Total Pengeluaran dari Pembayaran Operasional <?php if (strpos($_SESSION['jabatan'], 'Admin')===false){echo "Anda";}?> tahun <?php echo $year;?></h3>
				  <div class="box-tools pull-right">
					<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
				  </div>
				</div>
				<div class="box-body chart-responsive">
				  <div class="chart" id="chart-pembayaran-operasional" style="height: 300px;position: relative;"></div>
				</div>
				<!-- /.box-body -->
			  </div>
			  <!-- /.box -->
			  </div>

			<div class="col-md-6">
			  <!-- DONUT CHART -->
			  <div class="box box-danger">
				<div class="box-header with-border">
				  <h4 class="box-title">Jumlah Pembayaran Operasional <?php if(strpos($_SESSION['jabatan'], 'Admin')===false){echo " Anda ";}?>(per-kategori) <?php echo $month.", ".$year;?></h4>

				  <div class="box-tools pull-right">
					<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
				  </div>
				</div>
				<div class="box-body chart-responsive">
				  <div class="chart" id="sales-chart" style="height: 300px; position: relative;"></div>
				</div>
				<!-- /.box-body -->
			  </div>
			  <!-- /.box -->
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
    <div id="dataModal" class="modal fade" style="overflow: auto !important;">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Detail Kehadiran</h4>
        </div>
        <div class="modal-body" id="detail_kehadiran">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">CLOSE</button>
        </div>
      </div>
    </div>
  </div>
</body>
        <?php
          //list($one, $two) = explode(",", $_SESSION['jabatan'], 2);

        if (strpos($_SESSION['jabatan'], 'Admin')!==false) {
            ?>
            <script type="text/javascript">
                $('#shortcut-box').hide();
            </script>
            <?php
        } elseif (strpos($_SESSION['jabatan'], 'Admin')===false) {
            ?>
            <script type="text/javascript">
                 $('#shortcut-box').show();
            </script>
            <?php
        }

        if ($jumlah == "0") {
            ?>
            <script type="text/javascript">
                $('#notif_label').hide();
            </script>
            <?php
        }
        ?>
<?php
  
  $sql_data = "SELECT id_anggota, password, email FROM tb_anggota WHERE id_anggota = '$_SESSION[id_anggota]'";
  $query = mysqli_query($koneksi, $sql_data);

  $val_data = mysqli_fetch_assoc($query);

  $data_id = $val_data['id_anggota'];
  $data_pass = decodeData($val_data['password']);
  $data_email = $val_data['email'];
?>
<?php
if (strpos($_SESSION['jabatan'], 'Admin')!==false) {
    ?>
    <script type="text/javascript">
          $('#shortcut-box').hide();
    </script>
<?php
	} elseif ($data_id == $data_pass && strpos($_SESSION['jabatan'], 'Admin')===false || $data_email == '-') {
?>
    <script type="text/javascript">
          $('#shortcut-box').hide();
    </script>
<?php
	} else {
?>
     <script type="text/javascript">
          $('#shortcut-box').show();
    </script>
<?php
}
}
?>

