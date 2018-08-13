<?php
include "../../con_db.php";
	error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
	$sql = "UPDATE tb_detail_absen SET credit_stat='paid' WHERE credit_stat='unpaid' AND (MONTH(tanggal)=MONTH(CURRENT_DATE) AND YEAR(tanggal)=YEAR(CURRENT_DATE))";
	$result = mysqli_query($koneksi,$sql);
	 if (!$result) {
              printf("Error: %s\n", mysqli_error($koneksi));
              exit();
    } else {
		echo '<script type="text/javascript">
		alert("Semua AKOMODASI anggota bulan ini telah dibayar");
		document.location.href="../../tampil/data-akomodasi" 
		</script>';
	}
?>
