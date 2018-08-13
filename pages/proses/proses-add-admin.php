<?php
	if(isset($_POST['id']) && isset($_POST['nama']) && isset($_POST['email']) && isset($_POST['password'])){
		$id=antiInjection($_POST['id']);
		$nama=antiInjection($_POST['nama']);
		$email=antiInjection($_POST['email']);
		$pass=antiInjection($_POST['password']);
		$pass=encodeData($pass);
		$errmsg=null;
		$qry="INSERT INTO tb_anggota (id_anggota, nama, email, alamat, tempat_lahir, tgl_lahir, jenis_kelamin, password, foto_profile) VALUES('$id', '$nama', '$email', '-', '-', '-' , '-',  '$pass','-')";
		inUpDel($qry,$errmsg);
		if ($errmsg!=null) {
			echo "error: ".$errmsg;
		} else {
			$errmsg2=null;
			$qry2="INSERT INTO tb_jabatan (id_jabatan,jabatan, gaji) VALUES('111', 'Admin', 0)";
			inUpDel($qry2,$errmsg2);
			if ($errmsg2!=null) {
				echo "error: ".$errmsg;
			}
			$errmsg3=null;
			$qry3="INSERT INTO jabatan_anggota (id_anggota,id_jabatan) VALUES('$id','111')";
			inUpDel($qry3,$errmsg3);
			if ($errmsg3!=null) {
				echo "error: ".$errmsg;
			}
			echo '<script>alert("Admin Berhasil Ditambah");window.location="' . $obsolutePath . 'login/form"</script>';
		}

	}
?>