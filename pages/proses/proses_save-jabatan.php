<?php
	error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
		if(isset($_POST['submit_jabatan'])){
		include "../../con_db.php"; //sambung ke database

		//mengambil nilai dari form
		$id = $_POST['id_jabatan'];
		$jabatan = $_POST['jabatan'];
		$nominal= $_POST['gaji'];
		$gaji = str_replace('.', '', $nominal);
		//query untuk memasukan ke database
		$query = "INSERT INTO tb_jabatan (id_jabatan, jabatan, gaji) VALUES ('$id', '$jabatan','$gaji')";
		$insert = mysqli_query($koneksi, $query);

			if (!$insert) {
				printf("Error: %s\n", mysqli_error($koneksi));
				exit();
				} 
		echo '<script> alert("Data Jabatan Berhasil Disimpan"); document.location.href="../../tampil/data-jabatan" </script>';
	}
?>