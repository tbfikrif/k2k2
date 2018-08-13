<?php
	error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
	session_start();
	$nama = $_SESSION["nama"];
	if($_SESSION["nama"]==''){
		?>
		<script>
		alert('Anda Belum Login, Silahkan Login dulu');
		window.open('forms/form_login.php','_self');
		</script>
		<?php
	} 
	if(isset($_POST['submit_libur'])){
	include "../../con_db.php"; //sambung ke database

	//mengambil nilai dari form
	$nama_libur = $_POST["nama_libur1"];
	$rangelibur = $_POST["reservation"];
	$tgl1 = substr($rangelibur,0,11);
	$tgl2 = substr($rangelibur,13,25);
	$query = "INSERT INTO tb_tgllibur (nama_libur,tglawal,tglakhir,jmlhari) VALUES ('$nama_libur',STR_TO_DATE('$tgl1', '%m/%d/%Y'),STR_TO_DATE('$tgl2', '%m/%d/%Y')";
	$insert = mysqli_query($koneksi, $query) or trigger_error("Query Failed! SQL: $query - Error: ".mysqli_error($koneksi), E_USER_ERROR);
?>
<script> alert("Tanggal Libur Berhasil Disimpan"); document.location.href="../../tampil/data-libur" </script>
<?php
}
?>