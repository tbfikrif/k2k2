<?php
	include "../../con_db.php";
	error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
	session_start();
	$id = $_SESSION['idcredit'];

	$sql = "DELETE FROM tb_credits_anggota WHERE id='$id'";
	$result = mysqli_query($koneksi,$sql);

	 if (!$result) {
        printf("Error: %s\n", mysqli_error($koneksi));
        exit();
        } else {		
  		echo '<script type="text/javascript">alert("Data credit dengan ID'.$id.' berhasil dihapus");document.location.href="../../tampil/list-data-credits"</script>';
	}
?>
