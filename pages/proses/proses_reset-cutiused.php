<?php
include "../../con_db.php";
	error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
	session_start();
	$id = $_SESSION['idcuti'];

	$sql = "UPDATE tb_cuti_anggota SET cuti_used=0 WHERE id_anggota='$id'";
	$result = mysqli_query($koneksi,$sql);

	 if (!$result) {
              printf("Error: %s\n", mysqli_error($koneksi));
              exit();
              } else {

?>
  	<script type="text/javascript">
	alert("Cuti Used dengan ID <?php echo $id ?>, berhasil direset");
	document.location.href="../../tampil/data-cuti" 
	</script>
<?php 
}
?>
