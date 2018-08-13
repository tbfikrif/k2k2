<?php
	error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
	if(isset($_POST['submit_credit'])){
	include "../../con_db.php"; //sambung ke database

	//mengambil nilai dari form
	$id = $_POST['id_anggota1'];
	$nominal1 = $_POST['topup_credit1'];
	//$nominal2= $_POST['total_credit'];
	$topup = str_replace('.', '', $nominal1);
	//$total_credit = str_replace(',', '', $nominal2);
	//query untuk memasukan ke database
	$nominal2 = $_POST['topup_credit2'];
	//$nominal2= $_POST['total_credit'];
	$topup2 = str_replace('.', '', $nominal2);
		$query = "INSERT INTO tb_credits_anggota (id_anggota, topup_credit,uang_makan) VALUES ('$id', '$topup','$topup2')";
		$insert = mysqli_query($koneksi, $query);
	if (!$insert) {
        printf("Error: %s\n", mysqli_error($koneksi));
        exit();
    } 
	echo '<script>alert("Data Akomodasi Berhasil Disimpan");window.location="../../tampil/data-akomodasi"</script>';
}
?>