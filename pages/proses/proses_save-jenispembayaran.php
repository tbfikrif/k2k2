<?php
	error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
	if(isset($_POST['submit_jenis'])){
	include "../../con_db.php"; //sambung ke database

	//mengambil nilai dari form
	$id = $_POST['id_jenis'];
	$jenis = $_POST['jenis'];

	//query untuk memasukan ke database
	$query = "INSERT INTO tb_jenistransaksi (id_jenis, jenis) VALUES ('$id', '$jenis')";
	$insert = mysqli_query($koneksi, $query);

	 if (!$insert) {
              printf("Error: %s\n", mysqli_error($koneksi));
              exit();
              } 
	echo '<script> alert("Jenis Transaksi Berhasil Disimpan"); document.location.href="../../tampil/jenis-pembayaran" </script>';
}
?>