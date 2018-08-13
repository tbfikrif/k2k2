<?php
include "../../con_db.php";
	error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
	session_start();
	$id = $_SESSION['idhapus'];

	$sql = "DELETE FROM tb_jabatan WHERE id_jabatan='$id'";
	$result = mysqli_query($koneksi,$sql);

	 if (!$result) {
              printf("Error: %s\n", mysqli_error($koneksi));
              exit();
              } else {
  					echo '<script type="text/javascript">alert("Data jabatan dengan ID: '.$id.' berhasil dihapus");document.location.href="../../tampil/data-jabatan"</script>';
			}
?>