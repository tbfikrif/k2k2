<?php
 error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
 date_default_timezone_set("Asia/Jakarta");
 if (strpos($_SESSION['jabatan'], 'Admin')===false) {
  echo '<script>alert("Maaf, Anda bukan Admin"); window.location="tampil/home"</script>';
}
?>

<div class="container">
  <?php
    if(isset($_POST["submit"])){
      $startdate = $_POST["start_date"];
      $enddate = $_POST["end_date"];
      $_SESSION["tglfilterrekapabsen1"]=$startdate;
      $_SESSION["tglfilterrekapabsen2"]=$enddate;
      //echo '<script>alert("'.$_SESSION["tglfilterrekapabsen1"].'")</script>';
      $sql = "SELECT a.id_anggota AS id_ang,b.nama AS nama,COUNT(CASE WHEN a.status_id = 1 OR a.status_id=2 THEN 1 ELSE NULL END) AS jumhadir,COUNT(CASE WHEN ((a.status_id = 1 OR a.status_id=2  OR a.status_id=7) AND TIME(jam_masuk)>'10:00:00') THEN 1 ELSE NULL END) AS jumtelat,COUNT(CASE WHEN a.status_id = 3 THEN 1 ELSE NULL END) AS jumsakit,COUNT(CASE WHEN a.status_id = 4 THEN 1 ELSE NULL END) AS jumizin,COUNT(CASE WHEN a.status_id = 5 THEN 1 ELSE NULL END) AS jumcuti,COUNT(CASE WHEN a.status_id = 6 THEN 1 ELSE NULL END) AS jumalpha, SUM(a.credit_in) AS totalcredits FROM tb_detail_absen a JOIN tb_anggota b ON a.id_anggota=b.id_anggota WHERE DATE(a.tanggal) BETWEEN STR_TO_DATE('$startdate', '%m/%d/%Y') AND STR_TO_DATE('$enddate', '%m/%d/%Y') GROUP BY a.id_anggota WITH ROLLUP";
      echo '<h2 class="bounceInLeft animated">REKAP ABSENSI TANGGAL '.$startdate.' - '.$enddate.'</h2>';
    } else {
      $sql = "SELECT a.id_anggota AS id_ang,b.nama AS nama,COUNT(CASE WHEN a.status_id = 1 OR a.status_id=2 THEN 1 ELSE NULL END) AS jumhadir,COUNT(CASE WHEN ((a.status_id = 1 OR a.status_id=2  OR a.status_id=7) AND TIME(jam_masuk)>'10:00:00') THEN 1 ELSE NULL END) AS jumtelat,COUNT(CASE WHEN a.status_id = 3 THEN 1 ELSE NULL END) AS jumsakit,COUNT(CASE WHEN a.status_id = 4 THEN 1 ELSE NULL END) AS jumizin,COUNT(CASE WHEN a.status_id = 5 THEN 1 ELSE NULL END) AS jumcuti,COUNT(CASE WHEN a.status_id = 6 THEN 1 ELSE NULL END) AS jumalpha,SUM(a.credit_in) AS totalcredits  FROM tb_detail_absen a JOIN tb_anggota b ON a.id_anggota=b.id_anggota WHERE MONTH(a.tanggal)=MONTH('$today') AND YEAR(tanggal)=YEAR('$today') GROUP BY a.id_anggota WITH ROLLUP";
      $tglawal = date('m/01/Y');
      $tglkaliini = date('m/d/Y');
      echo '<h2 class="bounceInLeft animated">REKAP ABSENSI TANGGAL '.$tglawal.' - '.$tglkaliini.'</h2>';
    }
  ?>

<div>
<hr class="bounceInLeft animated" style="  
    border: 0;
    height: 1px;
    background: #333;
    background-image: linear-gradient(to right, #ccc, #333, #ccc);"
    >
    <div class="row">
                  <div class="col col-xs-6 flipInX animated">
                  <div class="form-group flipInX animated">
					  <form method="POST" action="tampil/data-rekap">
						  <div class="input-group"> 
							<input type="text" class="form-control" id="start_date" name="start_date" style="width: 100px;" placeholder="Dari"> 
							<input type="text" class="form-control" id="end_date" name="end_date" style="width: 100px; margin-left: 3px;" placeholder="Sampai">
							<input type="submit" name="submit" value="Filter Tanggal" class="btn btn-info" style="margin-left: 3px;">
						
						  </div>
					  </form>
					</div> 
                </div>
  </div>
<hr class="bounceInLeft animated" style="  
    border: 0;
    height: 1px;
    background: #333;
    background-image: linear-gradient(to right, #ccc, #333, #ccc);"
    >
</div>
</div>

<?php
   if (!defined('DIDALAM_INDEX_PHP')){ 
    //echo "Dilarang broh!";
        header("Location: ../../tampil/home");
    }
?>        
<div class="bounceInUp animated table-responsive">
  <table class="table table-bordered" id="table_rekap">
    <thead>
      <tr align="center">
        <th style="text-align: center;">ID Anggota</th>
        <th style="text-align: center;">Nama</th>
        <th style="text-align: center;">Jumlah Hadir</th>
        <th style="text-align: center;">Jumlah Telat</th>
        <th style="text-align: center;">Jumlah Sakit</th>
        <th style="text-align: center;">Jumlah Izin</th>
        <th style="text-align: center;">Jumlah Cuti</th>
        <th style="text-align: center;">Jumlah Alpha</th>
        <th style="text-align: center;">Akomodasi</th>
      </tr>
    </thead>
    <tbody>
            <?php

           
           $result = mysqli_query($koneksi,$sql);

           if (!$result) {
              //echo "sql yg 1 <br>";
              printf("Error: %s\n", mysqli_error($koneksi));
              exit();
              }
            while($r = mysqli_fetch_array($result))
            {
              if ($r["id_ang"]===null) {
                $totalhadir=$r["jumhadir"];
                $totaltelat=$r["jumtelat"];
                $totalsakit=$r["jumsakit"];
                $totalizin=$r["jumizin"];
                $totalcuti=$r["jumcuti"];
                $totalalpha=$r["jumalpha"];
                $totalakomodasi=$r["totalcredits"];
              } else {
            ?>
            <tr>
              <td><a id="<?php echo $r["id_ang"] ?>" type="button" class="btn btn-default btn-block btn-sm active view_data_anggota"><?php echo $r["id_ang"] ?></a></td>
              <td><a type="button" class="btn btn-default btn-block btn-sm active disabled"><?php echo $r["nama"] ?></a></a></td>
              <td><a href="tampil/data-absensi/<?php echo $r['id_ang']?>/hadir" class="btn btn-info btn-block btn-sm" name="id_anggota_rekap" ><?php echo $r["jumhadir"] ?></button></td>
              <td><a href="tampil/data-absensi/<?php echo $r['id_ang']?>/telat" class="btn btn-primary btn-block btn-sm" name="id_anggota_rekap" ><?php echo $r["jumtelat"] ?></button></td>
              <td><a href="tampil/data-absensi/<?php echo $r['id_ang']?>/sakit" class="btn btn-danger btn-block btn-sm" name="id_anggota_rekap"><?php echo $r["jumsakit"] ?></button></td>
              <td><a href="tampil/data-absensi/<?php echo $r['id_ang']?>/izin" class="btn btn-warning btn-block btn-sm" name="id_anggota_rekap"><?php echo $r["jumizin"] ?></button></td>
              <td><a href="tampil/data-absensi/<?php echo $r['id_ang']?>/cuti" class="btn btn-success btn-block btn-sm" name="id_anggota_rekap"><?php echo $r["jumcuti"] ?></button></td>
              <td><a href="tampil/data-absensi/<?php echo $r['id_ang']?>/alpha" class="btn btn-default btn-block btn-sm" name="id_anggota_rekap"><?php echo $r["jumalpha"] ?></button></td>
              <td><a type="button" class="btn btn-default btn-block btn-sm active disabled" ><?php echo $r["totalcredits"]?></a></td>
            </tr>
              <?php
                $no++;
              }
            }
          ?>          
    </tbody>
    <tfoot>
								<tr>
								  <th><a type="button" style="color: black;font-weight: bold;" class="btn btn-default btn-block btn-md active disabled">Total</a></th>
								  <th><a type="button" style="color: black;font-weight: bold;" class="btn btn-default btn-block btn-md active disabled"><?php echo $no?></a></th>
								  <th><a type="button" style="color: black;font-weight: bold;" class="btn btn-info btn-block btn-md "><?php echo $totalhadir?></a></th>
                  <th><a type="button" style="color: black;font-weight: bold;" class="btn btn-primary btn-block btn-md "><?php echo $totaltelat?></a></th>
								  <th><a type="button" style="color: black;font-weight: bold;" class="btn btn-danger btn-block btn-md "><?php echo $totalsakit?></a></th>
								  <th><a type="button" style="color: black;font-weight: bold;" class="btn btn-warning btn-block btn-md "><?php echo $totalizin?></a></th>
								  <th><a type="button" style="color: black;font-weight: bold;" class="btn btn-success btn-block btn-md "><?php echo $totalcuti?></a></th>
									<th><a type="button" style="color: black;font-weight: bold;" class="btn btn-default btn-block btn-md"><?php echo $totalalpha?></a></th>
								  <th><a type="button" style="color: black;font-weight: bold;" class="btn btn-default btn-block btn-md active disabled"><?php echo $totalakomodasi?></a></th>
                </tr>  
    </tfoot>              
  </table>
  </div>
    <!-- Deprecated Feature Convert CSV 
    <button button type="button"  class="btn btn-danger pull-right">Convert PDF</button>
   <form action="pages/proses/proses_convert-csv.php" method="POST">
      <input type="submit" id="btn_convert" class="btn btn-primary pull-right" value="Konvert ke CSV" name="submit_csv-rekapabsen">  
  </form>
  -->
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
