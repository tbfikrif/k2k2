<?php
	include "../../fungsi_kakatu.php";
	error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
	session_start();
	$errmsg=null;
	prosesPaidCredit($_SESSION["id_anggota_credit"],$errmsg);
	if ($errmsg===null) {
		echo '<script type="text/javascript">
		alert("Anggota ID '.$_SESSION["id_anggota_credit"].', telah dibayar");
		document.location.href="../../tampil/data-credits" 
		</script>';
	} else {
		echo '<script type="text/javascript">
		alert("Telah Terjadi Error")
		</script>';
	}
	
?>