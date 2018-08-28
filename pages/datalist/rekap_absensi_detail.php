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
      $sql = "SELECT tb_detail_absen.id_anggota,nama,jam_masuk,tanggal,tb_absen.status,keterangan,credit_in,cuti_qty-cuti_used AS Sisa_Cuti FROM tb_detail_absen JOIN tb_anggota join tb_absen join tb_cuti_anggota WHERE tb_detail_absen.tanggal BETWEEN STR_TO_DATE('$startdate', '%m/%d/%Y') AND STR_TO_DATE('$enddate', '%m/%d/%Y') and tb_detail_absen.id_anggota = tb_anggota.id_anggota AND tb_absen.status_id = tb_detail_absen.status_id AND tb_anggota.id_anggota = tb_cuti_anggota.id_anggota ORDER BY tb_detail_absen.id_anggota ";
      echo '<h2 class="bounceInLeft animated">REKAP ABSENSI TANGGAL '.$startdate.' - '.$enddate.'</h2>';
    } else {
      $gettglawal = date('Y/m/01');
      $gettglkaliini = date('Y/m/24');
      $sql = "SELECT tb_detail_absen.id_anggota,nama,jam_masuk,tanggal,tb_absen.status,keterangan,credit_in,cuti_qty-cuti_used AS Sisa_Cuti FROM tb_detail_absen JOIN tb_anggota join tb_absen join tb_cuti_anggota WHERE tb_detail_absen.tanggal BETWEEN '$gettglawal' AND '$gettglkaliini' and tb_detail_absen.id_anggota = tb_anggota.id_anggota AND tb_absen.status_id = tb_detail_absen.status_id AND tb_anggota.id_anggota = tb_cuti_anggota.id_anggota ORDER BY tb_detail_absen.id_anggota ";
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
					  <form method="POST" action="tampil/data-rekap-detail">
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
        <th style="text-align: center; widows: 20px;">ID Anggota</th>
        <th style="text-align: center;">Nama</th>
        <th style="text-align: center;">Jam Masuk</th>
        <th style="text-align: center;">Tanggal</th>
        <th style="text-align: center;">Status</th>
        <th style="text-align: center;">Keterangan</th>
        <th style="text-align: center;">Credit In</th>
        <th style="text-align: center;">Sisa Cuti</th>
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
                $tempIDanggota= $r["id_anggota"]; 
            ?>
            <tr><td align="center" ><?php echo $r["id_anggota"] ?></td>
                <td align="center"><?php echo $r["nama"] ?></td>
                <td align="center"><?php echo $r["jam_masuk"] ?></td>
                <td align="center"><?php echo $r["tanggal"] ?></td>
                <td align="center"><?php echo $r["status"] ?></td>
                <td align="center"><?php echo $r["keterangan"] ?></td>
                <td align="center"><?php echo $r["credit_in"] ?></td>
                <td align="center"><?php echo $r["Sisa_Cuti"] ?></td>
            </tr>
                  <?php
                }
                $no++;
          ?>          
    </tbody>              
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
