<?php

	$db_host = "localhost";
	$db_user = "root";//EDIT
	$db_pass = "";
	$db_name = "kakatuco_absensi";

	$koneksi = mysqli_connect($db_host, $db_user, $db_pass);
	$find_db = mysqli_select_db($koneksi, $db_name);
	
?>